<?php
/*
Plugin Name: HTML Forms - MailChimp Update
Plugin URI: https://www.htmlforms.io/#utm_source=wp-plugin&utm_medium=html-forms&utm_campaign=plugins-page
Description: Not just another forms plugin. Simple and flexible.
Version: 0.0.1
Author: mnelson4
Author URI: https://cmljnelson.blog
License: GPL v3
Text Domain: hfumc

HTML Forms
Copyright (C) 2017-2020, Danny van Kooten, danny@ibericode.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
// Note: requires MC4WP plugin to be active and configured, see https://wordpress.org/plugins/mailchimp-for-wp/

// Give users a link to a form, and include "?hfmu_email={{their_email}}" as a querystring parameter.
// Then make sure the form has a hidden field named "EMAIL" whose value is "{{hfmu_email}}",
// eg `<input type="hidden" name="EMAIL" placeholder="Your email" required value="{{hfmu_email}}" />`
// Find your list ID (see https://mailchimp.com/help/find-audience-id/) and put it in $list_id below
// Find the HTML Forms slug (seen when editing the form) and put it in $form_slug
// Add any tags you want to $tags_data

// Now the user will get a link to the form, fill it out (no need to re-enter their email)
// and upon successful submission, those tags will be added to their MailChimp contact.

use \HTML_Forms\Submission;
use HTML_Forms\Form;

define('FIRST_SURVEY_SLUG', 'survey_1');
define('MAX_FOUNDING_MEMBERS', 50);
define('HFMU_SIGNUP_PAGE', 'get-a-major-discount-for-print-my-blog-pro-by-becoming-a-founding-member');

function getHfmuSettings(){
    require_once(__DIR__ . '/src/HFMUForm.php');
    require_once(__DIR__ . '/src/HFMUQuestion.php');
    require_once(__DIR__ . '/src/HFMUQuestionOption.php');
    require_once(__DIR__ . '/src/HFMUSettings.php');
    return new HFMUSettings(
        [
            new HFMUForm(
                FIRST_SURVEY_SLUG,
                true,
                [
                    new HFMUQuestion(
                        'tools',
                        'What similar tools have you used to Print My Blog? What did you like/dislike about them?',
                        'textarea'
                    ),
                    new HFMUQuestion(
                        'fav_feature',
                        'What is your favourite feature of Print My Blog (the free version of WordPress.org)?',
                        'textarea'
                    ),
                    new HFMUQuestion(
                        'purpose',
                        'What problem(s) do you hope Print My Blog Pro will help you solve?',
                        'checkbox',
                        [
                            new HFMUQuestionOption(
                                'print_backup',
                                'Backup my writing for when my blog isn\'t online anymore'
                            ),
                            new HFMUQuestionOption(
                                'blog_a_book',
                                'Write new book(s) (or other types of document) and blog simultaneously'
                            ),
                            new HFMUQuestionOption(
                                'book_a_blog',
                                'Convert existing posts to book(s) (or other types of documents)'
                            ),
                            new HFMUQuestionOption(
                                'edit',
                                'Make a copy for easy revising/editing content'
                            ),
                            new HFMUQuestionOption(
                                'visitor_print',
                                'Let site visitors print blog posts'
                            ),
                            new HFMUQuestionOption(
                                'share_print',
                                'Make a printed copy of blog posts to share offline'
                            ),
                        ],
                        true
                    ),
                    new HFMUQuestion(
                        'format',
                        'What format(s) do you want to export your content to?',
                        'checkbox',
                        [
                            new HFMUQuestionOption(
                                'print',
                                'Paper (print directly from your printer)'
                            ),
                            new HFMUQuestionOption(
                                'digital_pdf',
                                'Digital PDF (for reading on a computer or mobile device)'
                            ),
                            new HFMUQuestionOption(
                                'print_pdf',
                                'PDF (for printing and reading offline)'
                            ),
                            new HFMUQuestionOption(
                                'mobi',
                                'MOBI (Amazon eBook format)'
                            ),
                            new HFMUQuestionOption(
                                'epub',
                                'ePub (other eBook format)'
                            )
                        ],
                        true
                    ),
                    new HFMUQuestion(
                        'requested_feature',
                        'What features does Print My Blog Pro need the most?',
                        'checkbox',
                        [
                            new HFMUQuestionOption(
                                'cpts',
                                'Custom Post Types'
                            ),
                            new HFMUQuestionOption(
                                'table_of_contents',
                                'Table of Contents'
                            ),
                            new HFMUQuestionOption(
                                'links_to_footnotes',
                                'Convert hyperlinks to footnotes with page references'
                            ),
                            new HFMUQuestionOption(
                                'reorder_posts',
                                'Customize order of posts'
                            ),
                            new HFMUQuestionOption(
                                'save_settings',
                                'Save Settings'
                            ),
                            new HFMUQuestionOption(
                                'improve_layout',
                                'Improved automatic page layout/design'
                            ),
                            new HFMUQuestionOption(
                                'custom_template',
                                'Customizable templates'
                            )
                        ],
                        true
                    ),
                    new HFMUQuestion(
                        'website_purpose',
                        'What is the purpose of your website?',
                        'radio',
                        [
                            new HFMUQuestionOption(
                                'business_primary',
                                'Primary Business'
                            ),
                            new HFMUQuestionOption(
                                'business_secondary',
                                'Side Business'
                            ),
                            new HFMUQuestionOption(
                                'hobby',
                                'Non-financial/Hobby'
                            )
                        ],
                        true
                    ),
                    new HFMUQuestion(
                        'editor',
                        'Which editor do you prefer?',
                        'radio',
                        [
                            new HFMUQuestionOption(
                                'gutenberg',
                                'WordPress\'s Block Editor (aka Gutenberg, default since WordPress 5.0)'
                            ),
                            new HFMUQuestionOption(
                                'classic',
                                'Classic Editor (WordPress\'s default before 5.0, now requires using the "Classic Editor" plugin)'
                            ),
                            new HFMUQuestionOption(
                                'elementor',
                                'Elementor (WordPress plugin)'
                            ),
                        ],
                        true
                    ),
                    new HFMUQuestion(
                        'plugins',
                        'What plugin(s) do you use?',
                        'textarea'
                    ),
                    new HFMUQuestion(
                        'anything_else',
                        'Anything else you\'d like to say about Print My Blog Pro?',
                        'textarea'
                    )
                ]
            )
        ]
    );
}


// Get the user's email from the query parameters
add_filter(
    'hf_form_html',
    function ($html, Form $form) {
        $hfmuc_settings = getHfmuSettings();
        $email = '';
        if(isset($_GET['hfmuc_email'])){
            $email = $_GET['hfmuc_email'];
        } elseif(isset($_GET['hfmu_email']) ){
            $email = $_GET['hfmu_email'];
        }

        $form_settings = $hfmuc_settings->getFormData($form);
        if(! isset($_REQUEST['hf_preview_form'])
           && $form_settings instanceof HFMUSettings
           && $form_settings->requiresEmail()
           && ! $email
           && ! (defined('DOING_AJAX') && DOING_AJAX)){
            wp_redirect('/' . HFMU_SIGNUP_PAGE);
        }
        if($form_settings instanceof HFMUForm){
            $hfmuc_html = $form_settings->getHtml() . '<input type="hidden" name="redirect_slug" value="' . hfmu_redirect_slug() . '">';
        } else{
            $hfmuc_html = '';
        }
        
        return str_replace(
            [
                '{{hfmu_email}}',
                '{{hfmu_questions}}'
            ],
            [
                $email,
                $hfmuc_html
            ],
            $html
        ) ;
    },
    10,
    2
);

function hfmu_count_founding_members(){
    global $wpdb;
    $table       = $wpdb->prefix . 'hf_submissions';
    return $wpdb->get_var('SELECT COUNT(*) FROM ' . $table
                   . ' AS s INNER JOIN ' . $wpdb->posts . ' AS p ON s.form_id=p.ID  WHERE p.post_name="' . FIRST_SURVEY_SLUG . '";');
}

function hfmu_qualify_for_founding_member(){
    return hfmu_count_founding_members() < FIRST_SURVEY_SLUG;
}

function hfmu_redirect_slug(){
    return hfmu_qualify_for_founding_member() ? 'founding-member' : 'early-access';
}
// echo count_founding_members();die;
// Adds tags to the given user.
add_action(
    'hf_form_success',
    function (Submission $submission, Form $form) {
        $hfmuc_settings = getHfmuSettings();
        $form_settings = $hfmuc_settings->getFormData($form);
        $email_address = isset($submission->data['EMAIL']) ? $submission->data['EMAIL'] : '';
        if(! $form_settings instanceof HFMUForm || ! $email_address){
            return;
        }


        $api = mc4wp_get_api_v3();

        // aka "audience ID". See https://mailchimp.com/help/find-audience-id/
        $list_id = '32ccd044c3';

        // see https://mailchimp.com/developer/reference/lists/list-members/list-member-tags/#read-get_lists_list_id_members_subscriber_hash_tags
        $tags_data = [
            'tags' => [
                [
                    'name'   => $form_settings->getSlug() . '_respondent',
                    'status' => 'active',
                ],
            ],
        ];
        if(hfmu_qualify_for_founding_member()){
            $tags_data['tags'][] = [
                'name' => 'first_50_survey_respondents',
                'status' => 'active'
            ];
        } else {
            $tags_data['tags'][] = [
                'name' => 'subsequent_survey_respondents',
                'status' => 'active'
            ];
        }


        foreach($form_settings->questions() as $question){
            // Don't tag for open-ended questions.
            if(! $question->getOptions()){
                continue;
            }
            $answer = $submission->data[$question->getFullInputName($form_settings)];
            // If they selected nothing, don't tag for anything either.
            if(empty($answer)){
                continue;
            }
            if(is_array($answer)){
                foreach($answer as $answer_option_chosen) {
                    $tags_data['tags'][] = [
                        'name'   => $question->getInputName() . ':' . $answer_option_chosen . ' (' . $form_settings->getSlug() . ')',
                        'status' => 'active'
                    ];
                }
            } else {
                $tags_data['tags'][] = [
                    'name' => $question->getInputName() . ':' . $answer . ' (' . $form_settings->getSlug() . ')',
                    'status' => 'active'
                ];
            }
        }
        $result = $api->update_list_member_tags(
            $list_id,
            $email_address,
            $tags_data
        );
    },
    10,
    2
);