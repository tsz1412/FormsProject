<?php
/**
 * The template for displaying all single articles
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>
	<section id="primary" class="content-area container">
		<main id="main" class="site-main container" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

			    the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		?>
            <!-- MultiStep Form -->
            <div class="container-fluid">
                <div class="row justify-content-center mt-0">
                    <div class="col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-3 mb-2">

                        <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                            <h2><strong><?= __('Quiz', 'navado') ?></strong></h2>
                            <?php $status = get_quiz_status(get_current_user_id(), get_the_ID()); ?>

                            <p><?= __('Answer each question to go to next step. <br> You can\'t go backward after answering a question.', 'navado') ?></p>
                            <div class="row">
                                <div class="col-md-12 mx-0">
                                    <?php if(!empty($status)) : ?>
                                    Correct Answers: <?= $status['correct_answers'] ?><br>
                                    Overall Points: <?= $status['overall_points'] ?><br>
                                    Answered Questions: <?= $status['answered_questions'] ?><br>
                                    <?php endif; ?>
                                    <?php if($status['answered_questions'] < 3) : ?>

                                        <form id="msform">
                                        <!-- progressbar -->
                                        <?php
                                        if( have_rows('questions') ):

                                            // Loop through rows.
                                            $rows = get_field('questions');
                                        ?>
                                        <ul id="progressbar">
                                            <?php for ($i = 1; $i < count($rows) + 1; $i++) : ?>
                                            <li <?php if ($i == 1) : echo 'class="active"'; endif; ?> id="q<?= $i ?>-tab"><strong>Question #<?= $i ?></strong></li>
                                            <?php endfor; ?>
                                            <li id="confirm"><strong>Finish</strong></li>
                                        </ul>
                                        <!-- fieldsets -->
                                        <?php
                                        // Check rows exists.

                                            if( $rows ) {
                                                $i = 0; foreach( $rows as $row ): $i++;
                                                ?>
                                                    <fieldset id="step-<?= $i ?>" class="question" data-foo="foo">
                                                        <div class="form-card">
                                                            <h2 class="fs-title">Question #<?= $i ?></h2>
                                                            <h3><?= $row['question']['text'] ?></h3>
                                                            <?php $j = 0 ; foreach ($row['answers'] as $answer) : $j++ ?>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="<?= $j ?>" name="question<?=$i?>-response" id="q<?=$i?>a<?=$j?>" <?php if($j == 1): echo 'checked'; endif; ?>>
                                                                <label class="form-check-label" for="q<?=$i?>a<?=$j?>">
                                                                    <?= $answer['answer'] ?>
                                                                </label>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <input type="button" name="next" class="next action-button" data-article-id="<?= get_the_ID() ?>" data-user-id="<?= get_current_user_id() ?>" data-user-answer="1" data-question="<?= $i ?>" value="Next Step"/>
                                                    </fieldset>
                                                    <?php
                                                endforeach;
                                                ?>
                                                <fieldset>
                                                    <div class="form-card">
                                                        <h2 class="fs-title text-center"><?= __('Success!', 'novado') ?></h2>
                                                        <br><br>
                                                        <div class="row justify-content-center">
                                                            <div class="col-3">
                                                                <img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="fit-image">
                                                            </div>
                                                        </div>
                                                        <br><br>
                                                        <div class="row justify-content-center">
                                                            <div class="col-7 text-center">
                                                                <h5><?= __('You Have Successfully Answered the Quiz', 'novado') ?></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <?php
                                            }
                                            else{
                                                _e('No Questions found on that Quiz', 'novado');
                                            }
                                            endif;
                                           ?>
                                    </form>

                                    <?php else: ?>

                                        <p style="font-weight: bold; color: red"><?= __('You Finished the Quiz', 'novado'); ?></p>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</main><!-- #main -->
	</section><!-- #primary -->
<script>

</script>
<?php
endwhile; // End of the loop.

get_sidebar();
get_footer();
