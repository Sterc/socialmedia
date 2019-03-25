<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

class SocialMediaMessage extends xPDOSimpleObject
{
    /**
     * @access public.
     * @return String.
     */
    public function getTimeAgo()
    {
        $timestamp = $this->get('created');

        if (is_string($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        $days = (int) floor((time() - $timestamp) / 86400);
        $minutes = (int) floor((time() - $timestamp) / 60);

        $output = [
            'minutes'   => $minutes,
            'hours'     => ceil($minutes / 60),
            'days'      => $days,
            'weeks'     => ceil($days / 7),
            'months'    => ceil($days / 30),
            'date'      => date('Y-m-d H:i:s', $timestamp)
        ];

        if ($days < 1) {
            if ($minutes < 1) {
                return $this->xpdo->lexicon('socialmedia.time_seconds', $output);
            }

            if ($minutes === 1) {
                return $this->xpdo->lexicon('socialmedia.time_minute', $output);
            }

            if ($minutes <= 59) {
                return $this->xpdo->lexicon('socialmedia.time_minutes', $output);
            }

            if ($minutes === 60) {
                return $this->xpdo->lexicon('socialmedia.time_hour', $output);
            }

            if ($minutes <= 1380) {
                return $this->xpdo->lexicon('socialmedia.time_hours', $output);
            }

            return $this->xpdo->lexicon('socialmedia.time_day', $output);
        }

        if ($days === 1) {
            return $this->xpdo->lexicon('socialmedia.time_day', $output);
        }

        if ($days <= 6) {
            return $this->xpdo->lexicon('socialmedia.time_days', $output);
        }

        if ($days <= 7) {
            return $this->xpdo->lexicon('socialmedia.time_week', $output);
        }

        if ($days <= 29) {
            return $this->xpdo->lexicon('socialmedia.time_weeks', $output);
        }

        if ($days <= 30) {
            return $this->xpdo->lexicon('socialmedia.time_month', $output);
        }

        if ($days <= 180) {
            return $this->xpdo->lexicon('socialmedia.time_months', $output);
        }

        return $this->xpdo->lexicon('socialmedia.time_to_long', $output);
    }
}
