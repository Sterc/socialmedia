<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

$_lang['socialmedia']                                                   = 'Social Media';
$_lang['socialmedia.desc']                                              = 'Beheer alle social media berichten.';

$_lang['area_socialmedia']                                              = 'Social Media';

$_lang['setting_socialmedia.branding_url']                              = 'Branding';
$_lang['setting_socialmedia.branding_url_desc']                         = 'De URL waar de branding knop heen verwijst, indien leeg wordt de branding knop niet getoond.';
$_lang['setting_socialmedia.branding_url_help']                         = 'Branding (help)';
$_lang['setting_socialmedia.branding_url_help_desc']                    = 'De URL waar de branding help knop heen verwijst, indien leeg wordt de branding help knop niet getoond.';
$_lang['setting_socialmedia.cronjob']                                   = 'Cronjob herinnering';
$_lang['setting_socialmedia.cronjob_desc']                              = 'Zet deze instelling op "Ja" als er een cronjob is ingesteld voor social media, door deze instelling op "Ja" te zetten word er geen cronjob waarschuwing meer getoond.';
$_lang['setting_socialmedia.default_active']                            = 'Standaard status';
$_lang['setting_socialmedia.default_active_desc']                       = 'De standaard status van de social media berichten tijdens het synchroniseren van de social media kanalen.';
$_lang['setting_socialmedia.log_send']                                  = 'Log versturen';
$_lang['setting_socialmedia.log_send_desc']                             = 'Indien ja, het aangemaakte log bestand die automatisch word aangemaakt versturen via e-mail.';
$_lang['setting_socialmedia.log_email']                                 = 'Log e-mailadres(sen)';
$_lang['setting_socialmedia.log_email_desc']                            = 'De e-mailadres(sen) waar het log bestand heen gestuurd dient te worden. Meerdere e-mailadressen scheiden met een komma.';
$_lang['setting_socialmedia.log_lifetime']                              = 'Log levensduur';
$_lang['setting_socialmedia.log_lifetime_desc']                         = 'Het aantal dagen dat een log bestand bewaard moet blijven, hierna word het log bestand automatisch verwijderd.';
$_lang['setting_socialmedia.cronjob_hash']                              = 'Cronjob hash';
$_lang['setting_socialmedia.cronjob_hash_desc']                         = 'De hash van de cronjob, deze hash dient als parameter mee gegeven te worden met de cronjob.';
$_lang['setting_socialmedia.remove_emoji']                              = 'Verwijder Emoji';
$_lang['setting_socialmedia.remove_emoji_desc']                         = 'Indien "Ja" worden alle Emoji emoticons verwijderd uit de social media berichten tijdens de import. Emoji is alleen mogelijk met een \'utf8mb4\' database karakter set.';

$_lang['area_socialmedia_twitter']                                      = 'Social Media Twitter';
$_lang['setting_socialmedia.source_twitter_access_token']               = 'Twitter access token';
$_lang['setting_socialmedia.source_twitter_access_token_desc']          = 'De Twitter access token, deze is te verkrijgen via https://dev.twitter.com/.';
$_lang['setting_socialmedia.source_twitter_access_token_secret']        = 'Twitter access token secret';
$_lang['setting_socialmedia.source_twitter_access_token_secret_desc']   = 'De Twitter access token secret, deze is te verkrijgen via https://dev.twitter.com/.';
$_lang['setting_socialmedia.source_twitter_consumer_key']               = 'Twitter consumer key';
$_lang['setting_socialmedia.source_twitter_consumer_key_desc']          = 'De Twitter consumer key, deze is te verkrijgen via https://dev.twitter.com/.';
$_lang['setting_socialmedia.source_twitter_consumer_key_secret']        = 'Twitter consumer key secret';
$_lang['setting_socialmedia.source_twitter_consumer_key_secret_desc']   = 'De Twitter consumer key secret, deze is te verkrijgen via https://dev.twitter.com/.';
$_lang['setting_socialmedia.source_twitter_empty_posts']                = 'Twitter "Onbekend of leeg bericht" weergegeven.';
$_lang['setting_socialmedia.source_twitter_empty_posts_desc']           = 'Indien ja, worden de Twitter berichten met "Onbekend of leeg bericht" weergegeven.';

$_lang['area_socialmedia_facebook']                                     = 'Social Media Facebook';
$_lang['setting_socialmedia.source_facebook_client_id']                 = 'Facebook client ID';
$_lang['setting_socialmedia.source_facebook_client_id_desc']            = 'De Facebook client ID, deze is te verkrijgen via https://developers.facebook.com/.';
$_lang['setting_socialmedia.source_facebook_client_secret']             = 'Facebook client secret';
$_lang['setting_socialmedia.source_facebook_client_secret_desc']        = 'De Facebook client secret, deze is te verkrijgen via https://developers.facebook.com/.';
$_lang['setting_socialmedia.source_facebook_access_token']              = 'Facebook access token';
$_lang['setting_socialmedia.source_facebook_access_token_desc']         = 'De Facebook access token, deze is te verkrijgen via oAuth met de minimale scope "user_posts".';
$_lang['setting_socialmedia.source_facebook_empty_posts']               = 'Facebook "Onbekend of leeg bericht" weergegeven.';
$_lang['setting_socialmedia.source_facebook_empty_posts_desc']          = 'Indien ja, worden de Facebook berichten met "Onbekend of leeg bericht" weergegeven.';

$_lang['area_socialmedia_instagram']                                    = 'Social Media Instagram';
$_lang['setting_socialmedia.source_instagram_client_id']                = 'Instagram client ID';
$_lang['setting_socialmedia.source_instagram_client_id_desc']           = 'De Instagram client ID, deze is te verkrijgen via https://www.instagram.com/developer/.';
$_lang['setting_socialmedia.source_instagram_client_secret']            = 'Instagram client secret';
$_lang['setting_socialmedia.source_instagram_client_secret_desc']       = 'De Instagram client secret, deze is te verkrijgen via https://www.instagram.com/developer/.';
$_lang['setting_socialmedia.source_instagram_access_token']             = 'Instagram access token';
$_lang['setting_socialmedia.source_instagram_access_token_desc']        = 'De Instagram access token, deze is te verkrijgen via https://instagram.pixelunion.net/.';
$_lang['setting_socialmedia.source_instagram_empty_posts']              = 'Instagram "Onbekend of leeg bericht" weergegeven.';
$_lang['setting_socialmedia.source_instagram_empty_posts_desc']         = 'Indien ja, worden de Instagram berichten met "Onbekend of leeg bericht" weergegeven.';

$_lang['area_socialmedia_youtube']                                      = 'Social Media Youtube';
$_lang['setting_socialmedia.source_youtube_client_id']                  = 'Youtube client ID';
$_lang['setting_socialmedia.source_youtube_client_id_desc']             = 'De Youtube client ID, deze is te verkrijgen via https://console.developers.google.com/.';
$_lang['setting_socialmedia.source_youtube_client_secret']              = 'Youtube client secret';
$_lang['setting_socialmedia.source_youtube_client_secret_desc']         = 'De Youtube client secret, deze is te verkrijgen via https://console.developers.google.com/.';
$_lang['setting_socialmedia.source_youtube_refresh_token']              = 'Youtube refresh token';
$_lang['setting_socialmedia.source_youtube_refresh_token_desc']         = 'De Youtube refresh token, deze is te verkrijgen via oAuth met de minimale scope "https://www.googleapis.com/auth/youtube.readonly".';
$_lang['setting_socialmedia.source_youtube_empty_posts']                = 'Youtube "Onbekend of leeg bericht" weergegeven.';
$_lang['setting_socialmedia.source_youtube_empty_posts_desc']           = 'Indien ja, worden de Youtube berichten met "Onbekend of leeg bericht" weergegeven.';

$_lang['area_socialmedia_linkedin']                                     = 'Social Media LinkedIn';
$_lang['setting_socialmedia.source_linkedin_client_id']                 = 'LinkedIn client ID';
$_lang['setting_socialmedia.source_linkedin_client_id_desc']            = 'De LinkedIn client ID, deze is te verkrijgen via https://www.linkedin.com/developer/.';
$_lang['setting_socialmedia.source_linkedin_client_secret']             = 'LinkedIn client secret';
$_lang['setting_socialmedia.source_linkedin_client_secret_desc']        = 'De LinkedIn client secret, deze is te verkrijgen via https://www.linkedin.com/developer/.';
$_lang['setting_socialmedia.source_linkedin_access_token']              = 'LinkedIn access token';
$_lang['setting_socialmedia.source_linkedin_access_token_desc']         = 'De LinkedIn access token, deze is te verkrijgen via oAuth met de minimale scope "rw_company_admin".';
$_lang['setting_socialmedia.source_linkedin_empty_posts']               = 'LinkedIn "Onbekend of leeg bericht" weergegeven.';
$_lang['setting_socialmedia.source_linkedin_empty_posts_desc']          = 'Indien ja, worden de LinkedIn berichten met "Onbekend of leeg bericht" weergegeven.';

$_lang['area_socialmedia_pinterest']                                    = 'Social Media Pinterest';
$_lang['setting_socialmedia.source_pinterest_client_id']                = 'Pinterest client ID';
$_lang['setting_socialmedia.source_pinterest_client_id_desc']           = 'De Pinterest client ID, deze is te verkrijgen via https://developers.pinterest.com/.';
$_lang['setting_socialmedia.source_pinterest_client_secret']            = 'Pinterest client secret';
$_lang['setting_socialmedia.source_pinterest_client_secret_desc']       = 'De Pinterest client secret, deze is te verkrijgen via https://developers.pinterest.com/.';
$_lang['setting_socialmedia.source_pinterest_access_token']             = 'Pinterest access token';
$_lang['setting_socialmedia.source_pinterest_access_token_desc']        = 'De Pinterest access token, deze is te verkrijgen via oAuth met de minimale scope "read_public".';
$_lang['setting_socialmedia.source_pinterest_empty_posts']              = 'Pinterest "Onbekend of leeg bericht" weergegeven.';
$_lang['setting_socialmedia.source_pinterest_empty_posts_desc']         = 'Indien ja, worden de Pinterest berichten met "Onbekend of leeg bericht" weergegeven.';

$_lang['socialmedia.criteria']                                          = 'Criteria';
$_lang['socialmedia.criterias']                                         = 'Criteria';
$_lang['socialmedia.criteria_desc']                                     = 'Hier kun je alle criteria van de social media berichten beheren. Alleen berichten die voldoen aan de ingestelde criteria zullen gesynchroniseerd worden met MODx.';
$_lang['socialmedia.criteria_create']                                   = 'Nieuwe criteria';
$_lang['socialmedia.criteria_update']                                   = 'Criteria bewerken';
$_lang['socialmedia.criteria_remove']                                   = 'Criteria verwijderen';
$_lang['socialmedia.criteria_remove_confirm']                           = 'Weet je zeker dat je deze criteria wil verwijderen? Dit verwijderd ook alle social media berichten met deze criteria.';

$_lang['socialmedia.label_criteria_source']                             = 'Social media kanaal';
$_lang['socialmedia.label_criteria_source_desc']                        = 'Het social media kanaal voor de criteria.';
$_lang['socialmedia.label_criteria_criteria']                           = 'Criteria';
$_lang['socialmedia.label_criteria_criteria_desc']                      = 'De criteria waar de social media berichten aan moeten voldoen. Een criteria moet beginnen met een @ of #, gebruik een @ voor een gebruikersnaam en een # voor een zoeksuggestie. Voor sommige API\'s heb je een gebruikers ID nodig, dit doe je door @ID: te gebruiken.';
$_lang['socialmedia.label_criteria_active']                             = 'Actief';
$_lang['socialmedia.label_criteria_active_desc']                        = '';

$_lang['socialmedia.message']                                           = 'Bericht';
$_lang['socialmedia.messages']                                          = 'Berichten';
$_lang['socialmedia.messages_desc']                                     = 'Beheer hier de gesynchroniseerde berichten uit de social media kanalen. Social media kanalen zoals <span class="twitter">Twitter</span>, <span class="instagram">Instagram</span>, <span class="facebook">Facebook</span>, <span class="linkedin">LinkedIn</span> of <span class="youtube">Youtube</span> worden automatisch gesynchroniseerd met MODX.';
$_lang['socialmedia.message_show']                                      = 'Bekijk op [[+source]]';
$_lang['socialmedia.message_activate']                                  = 'Bericht weergeven';
$_lang['socialmedia.message_activate_confirm']                          = 'Weet je zeker dat je dit bericht wilt weergeven?';
$_lang['socialmedia.message_deactivate']                                = 'Bericht verbergen';
$_lang['socialmedia.message_deactivate_confirm']                        = 'Weet je zeker dat je dit bericht wilt verbergen?';
$_lang['socialmedia.messages_activate_selected']                        = 'Geselecteerde berichten weergeven';
$_lang['socialmedia.messages_activate_selected_confirm']                = 'Weet je zeker dat je de geselecteerde berichten wilt weergeven?';
$_lang['socialmedia.messages_deactivate_selected']                      = 'Geselecteerde berichten verbergen';
$_lang['socialmedia.messages_deactivate_selected_confirm']              = 'Weet je zeker dat je de geselecteerde berichten wilt verbergen?';
$_lang['socialmedia.messages_reset']                                    = 'Alle berichten verwijderen';
$_lang['socialmedia.messages_reset_confirm']                            = 'Weet je zeker dat je alle berichten wilt verwijderen?';
$_lang['socialmedia.messages_clean']                                    = 'Berichten opruimen';
$_lang['socialmedia.messages_clean_confirm']                            = 'Weet je zeker dat je alle oude berichten wilt opruimen?';

$_lang['socialmedia.label_message_source']                              = 'Kanaal';
$_lang['socialmedia.label_message_source_desc']                         = '';
$_lang['socialmedia.label_message_user_account']                        = 'Profiel';
$_lang['socialmedia.label_message_user_account_desc']                   = '';
$_lang['socialmedia.label_message_content']                             = 'Bericht';
$_lang['socialmedia.label_message_content_desc']                        = '';
$_lang['socialmedia.label_message_status']                              = 'Status';
$_lang['socialmedia.label_message_status_desc']                         = '';
$_lang['socialmedia.label_message_reactions']                           = 'Reacties';
$_lang['socialmedia.label_message_reactions_desc']                      = '';
$_lang['socialmedia.label_message_created']                             = 'Geplaatst';
$_lang['socialmedia.label_message_created_desc']                        = '';

$_lang['socialmedia.label_clean_label']                                 = 'Verwijder alle berichten per criteria, de laatste';
$_lang['socialmedia.label_clean_desc']                                  = 'actieve berichten moeten behouden blijven.';

$_lang['socialmedia.default_view']                                      = 'Standaard weergave';
$_lang['socialmedia.admin_view']                                        = 'Admin weergave';
$_lang['socialmedia.filter_status']                                     = 'Filter op status...';
$_lang['socialmedia.filter_criteria']                                   = 'Filter op criteria...';
$_lang['socialmedia.filter_source']                                     = 'Filter op kanaal...';
$_lang['socialmedia.show_source']                                       = 'Bekijk op [[+source]]';
$_lang['socialmedia.activate']                                          = 'Weergeven';
$_lang['socialmedia.deactivate']                                        = 'Verbergen';
$_lang['socialmedia.criteria_err_not_defined']                          = 'De volgende criteria "[[+criteria]]" begint niet met de verplichte @ of #.';
$_lang['socialmedia.messages_clean_executing']                          = 'Bezig met opruimen van berichten';
$_lang['socialmedia.messages_clean_success']                            = '[[+amount]] bericht(en) verwijderd.';

$_lang['socialmedia.unknow_message']                                    = 'Onbekend of leeg bericht';
$_lang['socialmedia.time_seconds']                                      = 'Minder dan 1 minuut geleden';
$_lang['socialmedia.time_minute']                                       = '1 minuut geleden';
$_lang['socialmedia.time_minutes']                                      = '[[+minutes]] minuten geleden';
$_lang['socialmedia.time_hour']                                         = '1 uur geleden';
$_lang['socialmedia.time_hours']                                        = '[[+hours]] uren geleden';
$_lang['socialmedia.time_day']                                          = '1 dag geleden';
$_lang['socialmedia.time_days']                                         = '[[+days]] dagen geleden';
$_lang['socialmedia.time_week']                                         = '1 week geleden';
$_lang['socialmedia.time_weeks']                                        = '[[+weeks]] weken geleden';
$_lang['socialmedia.time_month']                                        = '1 maand geleden';
$_lang['socialmedia.time_months']                                       = '[[+months]] maanden geleden';
$_lang['socialmedia.time_to_long']                                      = 'Meer dan een half jaar geleden';
$_lang['socialmedia.no_messages']                                       = 'Er zijn geen social media berichten.';
$_lang['socialmedia.socialmedia_cronjob_notice_desc']                   = '<strong>Herinnering:</strong> voor social media moet er een cronjob ingesteld zijn die elk uur alle berichten van de social media kanalen synchroniseert. Deze herinnering kan uit gezet worden via de systeem instellingen.';
