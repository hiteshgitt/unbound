<?php
/*
Plugin Name: Custom Interview Plugin
Description: A plugin to handle interview-related functionalities.
Version: 1.0
*/

class Custom_Interview_Plugin {
    public function __construct() {
        add_action('init', array($this, 'create_custom_post_type_taxonomy'));
        add_shortcode('interview_task1', array($this, 'interview_task1_shortcode'));
        add_shortcode('interview_task2', array($this, 'interview_task2_shortcode'));
        add_shortcode('interview_task3', array($this, 'interview_task3_shortcode'));
    }

    public function create_custom_post_type_taxonomy() {
        // Define custom post type
        register_post_type('interview', array(
            'labels' => array(
                'name' => 'Interviews',
                'singular_name' => 'Interview'
            ),
            'public' => true,
            'supports' => array('title', 'editor', 'author'),
        ));

        // Define custom taxonomy
        register_taxonomy('language', 'interview', array(
            'label' => 'Languages',
            'rewrite' => array('slug' => 'language'),
            'hierarchical' => true,
        ));
    }

    public function interview_task1_shortcode() {
        $api_url = 'https://jsonplaceholder.typicode.com/posts';
        $response = wp_remote_get($api_url);

        if (is_array($response) && !is_wp_error($response)) {
            $data = json_decode(wp_remote_retrieve_body($response), true);

            if ($data) {
                $output = '<ul>';
                foreach ($data as $entry) {
                    $output .= '<li>Id: ' . $entry['id'] . ' - Body: ' . $entry['body'] . '</li>';
                }
                $output .= '</ul>';
                return $output;
            } else {
                return 'No data found.';
            }
        } else {
            return 'Failed to fetch data.';
        }
    }

    public function interview_task2_shortcode() {
        $api_url = 'https://jsonplaceholder.typicode.com/posts';
        $response = wp_remote_get($api_url);

        if (is_array($response) && !is_wp_error($response)) {
            $data = json_decode(wp_remote_retrieve_body($response), true);

            if ($data) {
                $target_title = 'nesciunt quas odio';
                foreach ($data as $entry) {
                    if ($entry['title'] === $target_title) {
                        return $entry['id'];
                    }
                }
                return 'Title not found.';
            } else {
                return 'No data found.';
            }
        } else {
            return 'Failed to fetch data.';
        }
    }


    public function interview_task3_shortcode() {
        $api_url = 'https://jsonplaceholder.typicode.com/posts';
        $response = wp_remote_get($api_url);

        if (is_array($response) && !is_wp_error($response)) {
            $data = json_decode(wp_remote_retrieve_body($response), true);

            if ($data) {
                // Create a custom sort function based on ID
                usort($data, function($a, $b) {
                    return $a['id'] - $b['id'];
                });

                $titles = array_column($data, 'title');
                return json_encode($titles);
            } else {
                return 'No data found.';
            }
        } else {
            return 'Failed to fetch data.';
        }
    }
}



// Instantiate the plugin class
$custom_interview_plugin = new Custom_Interview_Plugin();
