<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

$_lang['socialmedia']                                                   = 'Social Media';
$_lang['socialmedia.desc']                                              = 'Manage all social media messages.';

$_lang['area_socialmedia']                                              = 'Social Media';

$_lang['setting_socialmedia.branding_url']                              = 'Branding';
$_lang['setting_socialmedia.branding_url_desc']                         = 'The URL of the branding button, if the URL is empty the branding button won\'t be shown.';
$_lang['setting_socialmedia.branding_url_help']                         = 'Branding (help)';
$_lang['setting_socialmedia.branding_url_help_desc']                    = 'The URL of the branding help button, if the URL is empty the branding help button won\'t be shown.';
$_lang['setting_socialmedia.cronjob']                                   = 'Cronjob reminder';
$_lang['setting_socialmedia.cronjob_desc']                              = 'Set this setting to "Yes" if you set up a cronjob for social media, By setting this setting to "Yes" the cronjob notification is no longer displayed.';
$_lang['setting_socialmedia.default_active']                            = 'Default status';
$_lang['setting_socialmedia.default_active_desc']                       = 'The default status of the social media messages during the synchronizing of the social media channels.';
$_lang['setting_socialmedia.log_send']                                  = 'Send log';
$_lang['setting_socialmedia.log_send_desc']                             = 'When yes, send the log file that will be created by email.';
$_lang['setting_socialmedia.log_email']                                 = 'Log e-mail address(es)';
$_lang['setting_socialmedia.log_email_desc']                            = 'The e-mail address(es) where the log file needs to be send. Separate e-mail addresses with a comma.';
$_lang['setting_socialmedia.log_lifetime']                              = 'Log lifetime';
$_lang['setting_socialmedia.log_lifetime_desc']                         = 'The number of days that a log file needs to be saved, after this the log file will be deleted automatically.';
$_lang['setting_socialmedia.cronjob_hash']                              = 'Cronjob hash';
$_lang['setting_socialmedia.cronjob_hash_desc']                         = 'The hash of the cronjob, this hash needs to be send as a parameter with the cronjob.';
$_lang['setting_socialmedia.remove_emoji']                              = 'Remove Emoji';
$_lang['setting_socialmedia.remove_emoji_desc']                         = 'When "Yes" all Emoji emoticons will be removed from social media messages during the import. Emoji is possible with an \'utf8mb4\' database character set.';
$_lang['setting_socialmedia.download_image']                            = 'Download images';
$_lang['setting_socialmedia.download_image_desc']                       = 'When "Yes" all the images of the social media messages will be download local.';
$_lang['setting_socialmedia.image_path']                                = 'Images directory';
$_lang['setting_socialmedia.image_path_desc']                           = 'The directory where the images of the social media messages will be downloaden.';

$_lang['area_socialmedia_twitter']                                      = 'Social Media Twitter';
$_lang['setting_socialmedia.source_twitter_access_token']               = 'Twitter access token';
$_lang['setting_socialmedia.source_twitter_access_token_desc']          = 'The Twitter access token, you can get this at https://dev.twitter.com/.';
$_lang['setting_socialmedia.source_twitter_access_token_secret']        = 'Twitter access token secret';
$_lang['setting_socialmedia.source_twitter_access_token_secret_desc']   = 'The Twitter access token secret, you can get this at https://dev.twitter.com/.';
$_lang['setting_socialmedia.source_twitter_consumer_key']               = 'Twitter consumer key';
$_lang['setting_socialmedia.source_twitter_consumer_key_desc']          = 'The Twitter consumer key, you can get this at https://dev.twitter.com/.';
$_lang['setting_socialmedia.source_twitter_consumer_key_secret']        = 'Twitter consumer key secret';
$_lang['setting_socialmedia.source_twitter_consumer_key_secret_desc']   = 'The Twitter consumer key secret, you can get this at https://dev.twitter.com/.';
$_lang['setting_socialmedia.source_twitter_empty_posts']                = 'Twitter "Unknown or empty message" show.';
$_lang['setting_socialmedia.source_twitter_empty_posts_desc']           = 'If yes, the Twitter message with "Unknown or empty message" will shown.';

$_lang['area_socialmedia_facebook']                                     = 'Social Media Facebook';
$_lang['setting_socialmedia.source_facebook_client_id']                 = 'Facebook client ID';
$_lang['setting_socialmedia.source_facebook_client_id_desc']            = 'The Facebook client ID, you can get this at https://developers.facebook.com/.';
$_lang['setting_socialmedia.source_facebook_client_secret']             = 'Facebook client secret';
$_lang['setting_socialmedia.source_facebook_client_secret_desc']        = 'The Facebook client secret, you can get this at https://developers.facebook.com/.';
$_lang['setting_socialmedia.source_facebook_access_token']              = 'Facebook access token';
$_lang['setting_socialmedia.source_facebook_access_token_desc']         = 'The Facebook access token, you can get this at oAuth with the minimum scope "user_posts".';
$_lang['setting_socialmedia.source_facebook_empty_posts']               = 'Facebook "Unknown or empty message" show.';
$_lang['setting_socialmedia.source_facebook_empty_posts_desc']          = 'If yes, the Facebook message with "Unknown or empty message" will shown.';

$_lang['area_socialmedia_instagram']                                    = 'Social Media Instagram';
$_lang['setting_socialmedia.source_instagram_client_id']                = 'Instagram client ID';
$_lang['setting_socialmedia.source_instagram_client_id_desc']           = 'The Instagram client ID, you can get this at https://www.instagram.com/developer/.';
$_lang['setting_socialmedia.source_instagram_client_secret']            = 'Instagram client secret';
$_lang['setting_socialmedia.source_instagram_client_secret_desc']       = 'The Instagram client secret, you can get this at https://www.instagram.com/developer/.';
$_lang['setting_socialmedia.source_instagram_access_token']             = 'Instagram access token';
$_lang['setting_socialmedia.source_instagram_access_token_desc']        = 'The Instagram access token, you can get this by https://instagram.pixelunion.net/.';
$_lang['setting_socialmedia.source_instagram_empty_posts']              = 'Instagram "Unknown or empty message" show.';
$_lang['setting_socialmedia.source_instagram_empty_posts_desc']         = 'If yes, the Instagram message with "Unknown or empty message" will shown.';

$_lang['area_socialmedia_youtube']                                      = 'Social Media Youtube';
$_lang['setting_socialmedia.source_youtube_client_id']                  = 'Youtube client ID';
$_lang['setting_socialmedia.source_youtube_client_id_desc']             = 'The Youtube client ID, you can get this at https://console.developers.google.com/.';
$_lang['setting_socialmedia.source_youtube_client_secret']              = 'Youtube client secret';
$_lang['setting_socialmedia.source_youtube_client_secret_desc']         = 'The Youtube client secret, you can get this at https://console.developers.google.com/.';
$_lang['setting_socialmedia.source_youtube_refresh_token']              = 'Youtube refresh token';
$_lang['setting_socialmedia.source_youtube_refresh_token_desc']         = 'The Youtube refresh token, you can get this with oAuth with the minimum scope "https://www.googleapis.com/auth/youtube.readonly".';
$_lang['setting_socialmedia.source_youtube_empty_posts']                = 'Youtube "Unknown or empty message" show.';
$_lang['setting_socialmedia.source_youtube_empty_posts_desc']           = 'If yes, the Youtube message with "Unknown or empty message" will shown.';

$_lang['area_socialmedia_linkedin']                                     = 'Social Media LinkedIn';
$_lang['setting_socialmedia.source_linkedin_client_id']                 = 'LinkedIn client ID';
$_lang['setting_socialmedia.source_linkedin_client_id_desc']            = 'The LinkedIn client ID, you can get this at https://www.linkedin.com/developer/.';
$_lang['setting_socialmedia.source_linkedin_client_secret']             = 'LinkedIn client secret';
$_lang['setting_socialmedia.source_linkedin_client_secret_desc']        = 'The LinkedIn client secret, you can get this at https://www.linkedin.com/developer/.';
$_lang['setting_socialmedia.source_linkedin_access_token']              = 'LinkedIn access token';
$_lang['setting_socialmedia.source_linkedin_access_token_desc']         = 'The LinkedIn access token, you can get this with oAuth with the minimum scope "rw_company_admin".';
$_lang['setting_socialmedia.source_linkedin_empty_posts']               = 'LinkedIn "Unknown or empty message" show.';
$_lang['setting_socialmedia.source_linkedin_empty_posts_desc']          = 'If yes, the LinkedIn message with "Unknown or empty message" will shown.';

$_lang['area_socialmedia_pinterest']                                    = 'Social Media Pinterest';
$_lang['setting_socialmedia.source_pinterest_client_id']                = 'Pinterest client ID';
$_lang['setting_socialmedia.source_pinterest_client_id_desc']           = 'The Pinterest client ID, you can get this at https://developers.pinterest.com/.';
$_lang['setting_socialmedia.source_pinterest_client_secret']            = 'Pinterest client secret';
$_lang['setting_socialmedia.source_pinterest_client_secret_desc']       = 'The Pinterest client secret, you can get this at https://developers.pinterest.com/.';
$_lang['setting_socialmedia.source_pinterest_access_token']             = 'Pinterest access token';
$_lang['setting_socialmedia.source_pinterest_access_token_desc']        = 'The Pinterest access token, you can get this with oAuth with the minimum scope "read_public".';
$_lang['setting_socialmedia.source_pinterest_empty_posts']              = 'Pinterest "Unknown or empty message" show.';
$_lang['setting_socialmedia.source_pinterest_empty_posts_desc']         = 'If yes, the Pinterest message with "Unknown or empty message" will shown.';

$_lang['socialmedia.criteria']                                          = 'Criteria';
$_lang['socialmedia.criterias']                                         = 'Criteria';
$_lang['socialmedia.criteria_desc']                                     = 'Manage here all the criteria that the social media needs to contain. Only the messages that contain this criteria will be gesynchroniseerd with MODx.';
$_lang['socialmedia.criteria_create']                                   = 'Create criteria';
$_lang['socialmedia.criteria_update']                                   = 'Update criteria';
$_lang['socialmedia.criteria_remove']                                   = 'Remove criteria';
$_lang['socialmedia.criteria_remove_confirm']                           = 'Are you sure you want to remove this criteria? THhis will also remove all the social media message within this criteria.';

$_lang['socialmedia.label_criteria_source']                             = 'Social media channel';
$_lang['socialmedia.label_criteria_source_desc']                        = 'The social media channel of the criteria.';
$_lang['socialmedia.label_criteria_criteria']                           = 'Criteria';
$_lang['socialmedia.label_criteria_criteria_desc']                      = 'The criteria that the social media messages needs to contain. A criteria needs to start with a @ or #, use a @ for a username and a # for a search query. Some API\'s needs an user ID, you can do this by @ID:.';
$_lang['socialmedia.label_criteria_active']                             = 'Active';
$_lang['socialmedia.label_criteria_active_desc']                        = '';

$_lang['socialmedia.message']                                           = 'Message';
$_lang['socialmedia.messages']                                          = 'Messages';
$_lang['socialmedia.messages_desc']                                     = 'Manage here all the synchronized messages of the social media channels. Social media channels like <span class="twitter">Twitter</span>, <span class="instagram">Instagram</span>, <span class="facebook">Facebook</span>, <span class="linkedin">LinkedIn</span> or <span class="youtube">Youtube</span> will be synchronized automatically with MODX.';
$_lang['socialmedia.message_show']                                      = 'Show on [[+source]]';
$_lang['socialmedia.message_activate']                                  = 'Show message';
$_lang['socialmedia.message_activate_confirm']                          = 'Are you sure you want to show this message?';
$_lang['socialmedia.message_deactivate']                                = 'Hide message';
$_lang['socialmedia.message_deactivate_confirm']                        = 'Are you sure you want to hide this message?';
$_lang['socialmedia.messages_activate_selected']                        = 'Show selected messages';
$_lang['socialmedia.massages_activate_selected_confirm']                = 'Are you sure you want show the selected messages.';
$_lang['socialmedia.messages_deactivate_selected']                      = 'Hide selected messages';
$_lang['socialmedia.messages_deactivate_selected_confirm']              = 'Are you sure you want hide the selected messages.';
$_lang['socialmedia.messages_reset']                                    = 'Remove all forms';
$_lang['socialmedia.messages_reset_confirm']                            = 'Are you sure you want to remove all the messages?';
$_lang['socialmedia.messages_clean']                                    = 'Clean messages';
$_lang['socialmedia.messages_clean_confirm']                            = 'Are you sur eyou want to clean all old messages?';

$_lang['socialmedia.label_message_source']                              = 'Channel';
$_lang['socialmedia.label_message_source_desc']                         = '';
$_lang['socialmedia.label_message_user_account']                        = 'Account';
$_lang['socialmedia.label_message_user_account_desc']                   = '';
$_lang['socialmedia.label_message_content']                             = 'Message';
$_lang['socialmedia.label_message_content_desc']                        = '';
$_lang['socialmedia.label_message_status']                              = 'Status';
$_lang['socialmedia.label_message_status_desc']                         = '';
$_lang['socialmedia.label_message_reactions']                           = 'Reacties';
$_lang['socialmedia.label_message_reactions_desc']                      = '';
$_lang['socialmedia.label_message_created']                             = 'Posted';
$_lang['socialmedia.label_message_created_desc']                        = '';

$_lang['socialmedia.label_clean_label']                                 = 'Remove all old message pro criteria, the latast';
$_lang['socialmedia.label_clean_desc']                                  = 'active messages needs to be exists.';

$_lang['socialmedia.default_view']                                      = 'Default view';
$_lang['socialmedia.admin_view']                                        = 'Admin view';
$_lang['socialmedia.filter_status']                                     = 'Filter on status...';
$_lang['socialmedia.filter_criteria']                                   = 'Filter on criteria...';
$_lang['socialmedia.filter_source']                                     = 'Filter on channel...';
$_lang['socialmedia.show_source']                                       = 'Show on [[+source]]';
$_lang['socialmedia.activate']                                          = 'Show';
$_lang['socialmedia.deactivate']                                        = 'Hide';
$_lang['socialmedia.criteria_err_not_defined']                          = 'The following criteria "[[+criteria]]" doest not start with the required @ or #.';
$_lang['socialmedia.messages_clean_executing']                          = 'Cleaning up messages';
$_lang['socialmedia.messages_clean_success']                            = '[[+amount]] message(s) removed.';

$_lang['socialmedia.unknow_message']                                    = 'Unknown or empty message';
$_lang['socialmedia.time_seconds']                                      = 'Less than a minute ago';
$_lang['socialmedia.time_minute']                                       = '1 minute ago';
$_lang['socialmedia.time_minutes']                                      = '[[+minutes]] minutes ago';
$_lang['socialmedia.time_hour']                                         = '1 hour ago';
$_lang['socialmedia.time_hours']                                        = '[[+hours]] hours ago';
$_lang['socialmedia.time_day']                                          = '1 day ago';
$_lang['socialmedia.time_days']                                         = '[[+days]] days ago';
$_lang['socialmedia.time_week']                                         = '1 week ago';
$_lang['socialmedia.time_weeks']                                        = '[[+weeks]] weeks ago';
$_lang['socialmedia.time_month']                                        = '1 month ago';
$_lang['socialmedia.time_months']                                       = '[[+months]] months ago';
$_lang['socialmedia.time_to_long']                                      = 'More than a half year ago';
$_lang['socialmedia.no_messages']                                       = 'There no social media messages available.';
$_lang['socialmedia.socialmedia_cronjob_notice_desc']                   = '<strong>Reminder:</strong> for social media a cronjob is required to synchronize the message of all the social media sources each hour. This notification can turned off in the system settings.';
