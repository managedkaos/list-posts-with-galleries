<?php
/*
  Plugin Name: List Posts With Galleries
  Plugin URI: http://managedkaos.com
  Description: List all posts that have a gallery.
  Version: 2014.05.22
  Author: Managed Kaos
  Author URI: http://managedkaos.com
  Author Email: info@managedkaos.com
  License:

  The MIT License (MIT)

  Copyright (c) 2014 Managed Kaos (info@managedkaos.com)

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  SOFTWARE.

 */
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {
    // Add a new submenu under Tools:
    add_management_page(__('List Posts With Galleries', 'menu-test'), __('List Posts With Galleries', 'menu-test'), 'manage_options', 'lpwg', 'mt_tools_page');
}

// mt_tools_page() displays the page content for the Test Tools submenu
function mt_tools_page() {
    global $post;
    $args = array(
        'posts_per_page' => 10,
        'order' => 'ASC',
        'orderby' => 'title'
    );

    $post_list = get_posts($args);
    ?>
    <div class="wrap">
        <h2>Posts With Galleries</h2>
        <ul class='subsubsub'>
            <li class='all'><a href='edit.php?post_type=page' class="current">All <span class="count">(1)</span></a> |</li>
            <li class='publish'><a href='edit.php?post_status=publish&amp;post_type=page'>Published <span class="count">(1)</span></a> |</li>
            <li class='trash'><a href='edit.php?post_status=trash&amp;post_type=page'>Trash <span class="count">(1)</span></a></li>
        </ul>

        <form id="posts-filter" action="" method="get">

            <?php //$wp_list_table->search_box(__('Search Links'), 'link'); ?>

            <?php //$wp_list_table->display(); ?>

            <div id="ajax-response"></div>
        </form>

        <table class="widefat" cellspacing="0">
            <tr>
                <th scope='col' id='title' class='manage-column column-title'  style=""><span>Title</span></th>
                <th scope='col' id='author' class='manage-column column-author'  style="">Author</th>
                <th scope='col' id='has_gallery' class='manage-column column-categories'  style="">Has Gallery</th>
                <!-- <th scope='col' id='tags' class='manage-column column-tags'  style="">Tags</th> --> 
                <th scope='col' id='comments' class='manage-column column-comments'  style=""><span><span class="vers"></span></span><span class="sorting-indicator"></span></th>
                <th scope='col' id='date' class='manage-column column-date'  style=""><span>Date</span><span class="sorting-indicator"></span></th>
            </tr>
            <?php
            foreach ($post_list as $post) : setup_postdata($post);
                if (!get_post_gallery()) :
                    continue;
                endif;
                ?>
                <tr>
                    <td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
                    <td><?php the_author(); ?></td>
                    <td>
                        <?php
                        if (get_post_gallery()) :
                            echo "yes!";
                        else :
                            echo "nope :(";
                        endif;
                        ?>
                    </td>
                    <!-- <td></td> -->
                    <td></td>           
                    <td><?php echo $post->post_date; ?></td>
                </tr>
                <?php //the_excerpt();  ?>
                <?php
            endforeach;
            wp_reset_postdata();
            ?></table></div>
<?php } ?>
