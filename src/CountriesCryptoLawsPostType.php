<?php

declare(strict_types=1);

namespace ccl\countrycryptolaws;

class CountriesCryptoLawsPostType
{
    // Represents the singular name of the post type
    public $single = "Law";
    // Represents the plural name of the post type
    public $plural = "Countries Crypto Laws";
    // Represents the actual type of the post
    public $type = "countriescryptolaws";
    private $resultOfRestApiOfCountries;

    /**
     * Main constructor for the class, where add_actions and add_filters are placed
     *
     * CountriesCryptoLawsPostType constructor.
     * @param array $result
     */
    public function __construct(array $result)
    {
        $this->resultOfRestApiOfCountries = $result;
        // Add 'init' action for adding custom post type
        add_action('init', array($this, 'add_post_type'));

        // Add post thumbnail support for the post type
        add_theme_support('post-thumbnails', array($this->type));
        add_image_size(strtolower($this->plural) . '-thumb-s', 220, 160, true);
        add_image_size(strtolower($this->plural) . '-thumb-m', 300, 180, true);

        // Add custom taxonomies for the post type
        add_action('init', array($this, 'add_taxonomies'), 0);

        // Add meta box for the post type
        add_action('add_meta_boxes', array($this, 'add_custom_metaboxes'));

        // Save entered data on post save
        add_action('save_post', array($this, 'save_postdata'));
    }

    /**
     * This function adds a custom post type for "Countries Crypto Laws"
     * using the register_post_type() function with specific options.
     * It creates an array of labels and options for the post type, then
     * passes them to the register_post_type() function to actually create
     * the post type in WordPress.
     *
     * @return void
     */
    public function add_post_type(): void
    {
        $labels = array(
            'name' => esc_html(_x($this->plural, 'post type general name', 'ccl')),
            'singular_name' => esc_html(_x($this->single, 'post type singular name', 'ccl')),
            'add_new' => esc_html(_x('Add ' . $this->single, $this->single, 'ccl')),
            'add_new_item' => esc_html(sprintf(__('Add New %s', 'ccl'), $this->single)),
            'edit_item' => esc_html(sprintf(__('Edit %s', 'ccl'), $this->single)),
            'new_item' => esc_html(sprintf(__('New %s', 'ccl'), $this->single)),
            'view_item' => esc_html(sprintf(__('View %s', 'ccl'), $this->single)),
            'search_items' => esc_html(sprintf(__('Search %s', 'ccl'), $this->plural)),
            'not_found' => esc_html(sprintf(__('No %s Found', 'ccl'), $this->plural)),
            'not_found_in_trash' => esc_html(sprintf(__('No %s found in Trash', 'ccl'), $this->plural)),
            'parent_item_colon' => ''
        );

        $options = array(
            'labels' => $labels,             //An array of labels for the post type
            'public' => true,                //Whether the post type is publicly queryable and can be shown in the front end
            'publicly_queryable' => true,    //Whether the post type can be queried publicly (e.g. via a URL)
            'show_ui' => true,               //Whether to generate a UI for the post type in the admin area
            'query_var' => true,             //Whether to allow the post type to be queried using a URL parameter
            'rewrite' => array('slug' => strtolower($this->plural)),  //Whether to rewrite the URL of the post type
            'show_in_rest' => true,          //Whether to enable REST API endpoints for the post type
            'capability_type' => 'post',     //The type of users who can edit this post type
            'hierarchical' => false,         //Whether the post type is hierarchical like pages
            'has_archive' => true,           //Whether the post type should have an archive page
            'menu_position' => null,         //The position in the menu order where the post type should appear
            'supports' => array(             //An array of features the post type supports
                'title',
                'editor',
                'thumbnail',
                'comments'
            ),
        );
        register_post_type($this->type, $options);  //Actually register the post type in WordPress
    }

    /**
     * Registers a custom taxonomy named 'continents' for the custom post type 'countriescryptolaws'.
     *
     * The taxonomy is non-hierarchical, has custom labels and is publicly queryable and accessible via REST API.
     * The taxonomy terms can be edited in the UI and are rewritten with the slug 'continents'.
     *
     * @return void
     */
    public function add_taxonomies(): void
    {
        register_taxonomy(
            'continents',
            array($this->type),
            array(
                'hierarchical' => false,
                'labels' => array(
                    'name' => __('Continent', 'ccl'),
                    'singular_name' => __('Continents', 'ccl'),
                    'all_items' => __('All Continents', 'ccl'),
                    'add_new_item' => __('Add New Continent', 'ccl')
                ),
                'public' => true,
                'query_var' => true,
                'show_in_rest' => true,
                'show_ui' => true,
                'rewrite' => array(
                    'slug' => 'continents'
                ),
            )
        );
    }

    /**
     * Adds a custom metabox named 'countriescryptolaws' to the custom post type 'countriescryptolaws'.
     *
     * The metabox displays a select field for the user to select a country and calls the 'displayCallback' function to render it.
     * The metabox is added to the 'normal' context and has a priority of 'low'.
     *
     * @return void
     */
    public function add_custom_metaboxes(): void
    {
        add_meta_box('countriescryptolaws', __('Select Country', 'ccl'), array($this, 'displayCallback'), $this->type, 'normal', 'low');
    }

    /**
     * Callback function to display the select box to choose a country.
     * Uses the RestApiHandler class to get a list of countries.
     * If the API call is successful, displays a select box with the list of countries.
     * If the API call is not successful, displays the error message returned by the API.
     *
     * @return void
     */
    public function displayCallback(): void
    {
        if ($this->resultOfRestApiOfCountries['result']) {
            global $post;
            $country = get_post_meta($post->ID, 'country', true);
            echo '<select name="country" id="countries-list">
            <option value="0">' . __('Select Country', 'ccl') . '</option>';
            foreach ($this->resultOfRestApiOfCountries['body'] as $item => $value) :
                ?>
                <option value="<?= $value['cca2'] ?>" <?= $country == $value['cca2'] ? "selected" : "" ?>><?= $value['name']['common'] ?></option>
            <?php
            endforeach;
            echo '</select>';
        } else {
            echo $this->resultOfRestApiOfCountries['body'];
        }
    }

    /**
     * Saves the post data when a post is updated or saved.
     * If the post is an autosave or revision, returns early.
     * Updates the post meta for the 'country' field with the value submitted via POST.
     *
     * @return void
     */
    public function save_postdata(int $post_id): void
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $fields = ['country'];

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
