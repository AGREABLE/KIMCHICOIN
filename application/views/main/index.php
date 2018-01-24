


        <!-- Content
        ============================================= -->
        <section id="content">

            <div class="content-wrap">

                <div class="container clearfix">

                    <!-- Posts
                    ============================================= -->
                    <div id="posts" class="post-grid grid-3 clearfix">

                    <?php
                    for ( $i = 0; $i < count( $data->lists ); $i++ ) {
                        $item = $data->lists[$i];
                        ?>
                        <div class="entry clearfix">
                            <div class="entry-image">
                                <a href="<?php echo $item->link?>" target="_blank"><img class="image_fade" src="<?php echo $item->img?>" alt="<?php echo $item->title?>"></a>
                            </div>
                            <div class="entry-title">
                                <h2><a href="<?php echo $item->link?>" target="_blank"><?php echo $item->title?></a></h2>
                            </div>
                            <ul class="entry-meta clearfix">
                                <li><i class="icon-calendar3"></i> <?php echo $item->created_at?></li>
                                <li><a href="#"><i class="icon-picture"></i></a></li>
                            </ul>
                            <div class="entry-content">
                                <p><?php echo strip_tags( $item->contents )?></p>
                                <a href="/main/article?s=<?php echo $item->source?>&k=<?php echo $item->external_key?>" class="more-link">Read More</a>
                            </div>
                        </div>
                    <?php } ?>

                    </div><!-- #posts end -->

                    <!-- Pagination
                    ============================================= -->

                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <div class="mb20"></div>
                            <ul class="pagination nobottommargin">
                                <?php echo $pagination;?>
                            </ul>
                        </div>
                    </div><!-- .pager end -->

                </div>

            </div>