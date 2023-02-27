<?php

declare(strict_types=1);

namespace ccl\countrycryptolaws;

class CountriesCryptoLawsShortCode
{
    /**
     * register a new shortcode 'country-laws' to be used in WordPress posts and pages
     *
     * CountriesCryptoLawsShortCode constructor.
     */
    public function __construct()
    {
        add_shortcode('country-laws', array($this, 'countriesCryptoLawsCallback'));
    }

    /**
     * callback function for the 'country-laws' shortcode
     *
     * @param array $attr
     * @return string
     */
    public function countriesCryptoLawsCallback(array $attr): string
    {
        wp_enqueue_style('custom-style-ccl', plugin_dir_url(__DIR__) . 'assets/css/custom-style-ccl.css');

        // retrieve the post data with 'countriescryptolaws' post type and with the 'country' meta value matching the 'cca2' attribute passed to the shortcode
        $args = array(
            'post_type' => 'countriescryptolaws',
            'meta_query' => array(
                array(
                    'key' => 'country',
                    'value' => $attr['cca2'],
                    'compare' => '='
                )
            ),
            //This code orders the results by date, in a descending order.
            //This ensures that the latest news is always displayed.
            'orderby' => 'date',
            'order' => 'DESC'
        );

        // get the posts based on the query parameters
        $posts = get_posts($args);

        // if it has posts
        if (!empty($posts)) {
            // initialize the output variable with the beginning of an unordered list
            $output = '<ul id=country-news-list>';

            // loop through the posts and add each post as a list item in the output variable
            foreach ($posts as $post) {
                $output .= '
                <li id="country-news">
                    <a href="' . get_permalink($post->ID) . '">' . $post->post_title . '</a>
                </li>
                ';
            }
            // close the unordered list
            $output .= '</ul>';
            // return the final output string
        }
        // prevent returning null
        return $output ?? '';
    }
}
