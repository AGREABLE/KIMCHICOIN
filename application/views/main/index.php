


        <!-- Content
        ============================================= -->
        <section id="content">

            <div class="content-wrap">

                <div class="container clearfix">

                    <!-- Posts
                    ============================================= -->
                    <div id="posts" class="post-grid grid-2 clearfix">

                    <?php
                    for ( $i = 0; $i < count( $data->lists ); $i++ ) {
                        $item = $data->lists[$i];
                        ?>
                        <div class="entry clearfix">
                            <div class="entry-title">
                                <h4><a href="/main/article?s=<?php echo $item->source?>&k=<?php echo $item->external_key?>" style="color:black;"><?php echo $item->_title?></a></h4>
                            </div>
                            <ul class="entry-meta clearfix">
                                <li><i class="icon-calendar3"></i> <?php echo $item->created_at?></li>
                                <li><a href="#"><i class="icon-picture"></i></a></li>
                            </ul>
                            <div class="entry-content">
                                <p><?php echo strip_tags( $item->_contents )?></p>
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