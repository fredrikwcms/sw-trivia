<?php

/**
*   Adds SW Trivia Widget.
*/

class Sw_Trivia_Widget extends WP_Widget {
    
    /**
    *   Register widget with WordPress.
    */

    public function __construct() {
        parent::__construct(
            'sw-trivia', // Base ID
            'SW Trivia Widget',
            [
                'description' => __('A Widget for fetching data from SWAPI', 'sw-trivia'),
            ] // Args
            );
    }
 
    /**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
    public function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        // Start widget
        echo $before_widget;

        // title
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        // content
        ?>
            <div class="content">
                <span class="loading">Loading...</span>
                <?php 
                    $alderaan = swapi_get_planet('2');
                    // $residents = $alderaan->residents;

                    // foreach ($residents as $resident) {
                    //     // @TODO remove parts of URL we dont need and save it as $character_id
                    //     $character = swapi_get_character("68");
                    //     echo $character->name;
                    // }
                    echo $alderaan->name;
                ?>
            </div>
        <?php
        
        // close widget
        echo $after_widget;
    }

    /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
    public function form( $instance ) {
        // outputs the options form in the admin
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }   else    {
            $title = __('Star Wars Trivia', 'sw-trivia');
        }
        ?>

        <!-- title -->
		<p>
			<label
				for="<?php echo $this->get_field_name('title'); ?>"
			>
				<?php _e('Title:'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				type="text"
				value="<?php echo esc_attr($title); ?>"
			/>
		</p>
		<!-- /title -->
    <?php
    }

    /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        $instance = [];

        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
}
 