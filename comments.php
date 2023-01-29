<?php
/**
 * The template for displaying Comments. The area of the page that contains
 * comments and the comment form.
 *
 * @package QubitsTech
 */

if ( post_password_required() ):
    return;
endif; ?>

<aside id="comments">
    <h2>Comments:</h2>
    <ol class="comment-list">
        <?php
            wp_list_comments( array(
                'style'       => 'div',
                'short_ping'  => true,
            ) );
        ?>
    </ol>
    <?php comment_form(); ?>
    <?php if (!comments_open()): ?>
        <div id="comments-closed">Comments on this post are now closed.</div>
    <?php endif; ?>
</aside>
