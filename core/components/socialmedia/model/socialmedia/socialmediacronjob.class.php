<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once __DIR__ . '/socialmedia.class.php';

class SocialMediaCronjob extends SocialMedia
{
    /**
     * @access protected.
     * @var Boolean.
     */
    protected $debugMode = false;

    /**
     * @access protected.
     * @var Array.
     */
    protected $timer = [
        'start' => null,
        'end'   => null,
        'time'  => null
    ];

    /**
     * @access protected.
     * @var Array.
     */
    protected $logs = [
        'log'   => [],
        'html'  => [],
        'clean' => []
    ];

    /**
     * @access public.
     * @param Boolean $debugMode.
     * @return Boolean.
     */
    public function setDebugMode($debugMode)
    {
        if ($debugMode) {
            $this->log('Debug mode is enabled. No database queries or media downloads will be executed.', 'notice');
        }

        $this->debugMode = $debugMode;

        return true;
    }

    /**
     * @access public.
     * @return Boolean.
     */
    public function getDebugMode()
    {
        return $this->debugMode;
    }

    /**
     * @access protected.
     * @param String $type.
     */
    protected function setTimer($type)
    {
        $this->timer[$type] = microtime(true);

        switch ($type) {
            case 'start':
                $this->log('Start import process at ' . date('d-m-Y H:i:s') . '.');

                break;
            case 'end':
                $this->timer['time'] = $this->timer['end'] - $this->timer['start'];

                $this->log('End import process at ' . date('d-m-Y H:i:s') . '.');
                $this->log('Total execution time in seconds: ' . number_format($this->timer['time'], 2) . '.');

                break;
        }
    }

    /**
     * @access protected.
     * @param String $message.
     * @param String $level.
     */
    protected function log($message, $level = 'info')
    {
        switch ($level) {
            case 'error':
                $prefix = 'ERROR::';
                $color  = 'red';

                break;
            case 'notice':
                $prefix = 'NOTICE::';
                $color  = 'yellow';

                break;
            case 'success':
                $prefix = 'SUCCESS::';
                $color  = 'green';

                break;
            default:
                $prefix = 'INFO::';
                $color  = 'blue';

                break;
        }

        $log    = $this->colorize($prefix, $color) . ' ' . $message;
        $html   = '<span style="color: ' . $color . '">' . $prefix . '</span> ' . $message;

        if (XPDO_CLI_MODE) {
            $this->modx->log(MODX_LOG_LEVEL_INFO, $log);
        } else {
            $this->modx->log(MODX_LOG_LEVEL_INFO, $html);
        }

        /*
         * logMessage has CLI markup
         * htmlMessage has HTML markup
         * cleanMessage has no markup
         */
        $this->logs['log'][]   = $log;
        $this->logs['html'][]  = $html;
        $this->logs['clean'][] = $prefix . ' ' . $message;
    }

    /**
     * @access protected.
     * @param String $string.
     * @param String $color.
     * @return String.
     */
    protected function colorize($string, $color = 'white')
    {
        switch ($color) {
            case 'red':
                return "\033[31m" . $string . "\033[39m";

                break;
            case 'green':
                return "\033[32m" . $string . "\033[39m";

                break;
            case 'yellow':
                return "\033[33m" . $string . "\033[39m";

                break;
            case 'blue':
                return "\033[34m" . $string . "\033[39m";

                break;
            default:
                return $string;

                break;
        }
    }

    /**
     * @access protected.
     * @param String $type.
     * @return Boolean.
     */
    protected function setState($type)
    {
        switch ($type) {
            case 'start':
                // Noting to do

                break;
            case 'end':
                if ($log = $this->getLogFile()) {
                    if ((int) $this->modx->getOption('socialmedia.log_send') === 1 && !$this->getDebugMode()) {
                        $this->sendLogFile($log);
                    }
                }

                $this->cleanFiles();

                break;
        }

        return true;
    }

    /**
     * @access protected.
     * @return String|Boolean.
     */
    protected function getLogFile()
    {
        $path       = dirname(dirname(__DIR__)) . '/logs/';
        $filename   = $path . date('Ymd_His') . '.log';

        if ($this->getDebugMode()) {
            $filename = $path . '_DEBUG_' . date('Ymd_His') . '.log';
        }

        if (is_dir($path) && is_writable($path)) {
            if ($handle = fopen($filename, 'wb')) {
                if (isset($this->logs['clean']) || count($this->logs['clean']) === 0) {
                    fwrite($handle, implode(PHP_EOL, $this->logs['clean']));
                    fclose($handle);

                    $this->log('Log file created `' . $filename . '`.', 'success');

                    return $filename;
                }

                $this->log('No messages to log', 'notice');
            } else {
                $this->log('Could not create log file.', 'notice');
            }
        } else {
            $this->log('Log directory `' . $path . '` does not exists or is not readable.', 'notice');
        }

        return false;
    }

    /**
     * @access protected.
     * @param String $log.
     * @return Boolean.
     */
    protected function sendLogFile($log)
    {
        $mail = $this->modx->getService('mail', 'mail.modPHPMailer');

        if ($mail) {
            $mail->set(modMail::MAIL_FROM, $this->modx->getOption('emailsender'));
            $mail->set(modMail::MAIL_FROM_NAME, $this->modx->getOption('site_name'));
            $mail->set(modMail::MAIL_SUBJECT, $this->modx->getOption('site_name') . ' | Social Media sync');

            $mail->set(modMail::MAIL_BODY, $this->modx->getOption('socialmedia.log_body', null, 'Log file is attached to this email.'));

            $mail->mailer->AddAttachment($log);

            $emails = explode(',', $this->modx->getOption('socialmedia.log_email', null, $this->modx->getOption('emailsender')));

            foreach ($emails as $email) {
                $mail->address('to', trim($email));
            }

            if ($mail->send()) {
                $this->log('Log file send to `' . implode(', ', $emails) . '`.', 'success');
            } else {
                $this->log('Log file send failed.', 'error');
            }

            $mail->reset();
        }

        return true;
    }

    /**
     * @access protected.
     */
    protected function cleanFiles()
    {
        $this->log('Start clean up process.');

        $lifetime = $this->modx->getOption('socialmedia.log_lifetime', null, 7);

        $this->log('Log file lifetime is `' . $lifetime . '` days.');

        $files = [
            'logs' => 0
        ];

        $path = dirname(dirname(__DIR__)) . '/logs/';

        foreach (glob($path . '*.log') as $file) {
            if (filemtime($file) < (time() - (86400 * (int) $lifetime))) {
                unlink($file);

                $files['logs']++;
            }
        }

        $this->log($files['logs'] . ' log file(s) cleaned due lifetime.');

        $this->log('End clean up process.');
    }

    /**
     * @access public.
     * @return Boolean.
     */
    public function run()
    {
        $this->setState('start');
        $this->setTimer('start');

        $this->import();

        $this->setTimer('end');
        $this->setState('end');

        return true;
    }

    /**
     * @access public.
     * @return Boolean.
     */
    protected function import()
    {
        $this->modx->cacheManager->refresh([
            'socialmedia' => []
        ]);

        foreach ((array) $this->getCriteria() as $criteria) {
            $source = $this->getSource($criteria->get('source'));

            if ($source) {
                $this->log('Import process for `' . $source->getName() . '` with criteria `' . $criteria->get('criteria') .'`.');

                $response = $source->getData($criteria->get('criteria'), $criteria->getCredentials());

                if ((int) $response['code'] === 200) {
                    $count = [
                        'create' => [],
                        'update' => []
                    ];

                    foreach ((array) $response['data'] as $data) {
                        $message = $this->modx->getObject('SocialMediaMessage', [
                            'key'       => $data['key'],
                            'source'    => $data['source']
                        ]);

                        if ($message) {
                            $count['update'][] = $data['key'];
                        } else {
                            $message = $this->modx->newObject('SocialMediaMessage', [
                                'active' => $this->modx->getOption('socialmedia.default_active', null, 1)
                            ]);

                            $count['update'][] = $data['key'];
                        }

                        if ($message) {
                            $message->fromArray(array_merge($data, [
                                'criteria_id' => $criteria->get('id')
                            ]));

                            $message->save();
                        }
                    }

                    $this->log(' - Created ' . count($count['create']) . ' messages.');
                    $this->log(' - Updated ' . count($count['update']) . ' messages.');
                    $this->log('Import process for `' . $source->getName() . '` with criteria `' . $criteria->get('criteria') .'` succeed.', 'success');
                } else {
                    $this->log('Import process for `' . $source->getName() . '` with criteria `' . $criteria->get('criteria') .'` failed `' . $response['message'] . '`.', 'error');
                }
            } else {
                $this->log('Cannot initialize service for "' . $criteria->get('criteria') . '".', 'error');
            }
        }

        $this->modx->invokeEvent('OnSocialMediaCronjob');

        return true;
    }
}
