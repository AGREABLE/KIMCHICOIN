


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
                                <h4><a href="/<?php echo $ci->menu->current[0]['v']?>/article?s=<?php echo $item->source?>&k=<?php echo $item->external_key?>" style="color:black;"><?php echo $item->_title?></a></h4>
                            </div>
                            <ul class="entry-meta clearfix">
                                <li class="timeago" datetime="<?php echo $item->create_timestamp?>"><i class="icon-calendar3"></i> <?php echo $item->created_at?></li>
                                <?php if( $item->duedate && strtotime( $item->duedate ) >= strtotime( date( 'Y-m-d' ) ) ) { ?>
                                <li class="dday"><?php echo ( strtotime( $item->duedate ) == strtotime( date( 'Y-m-d' ) ) ) ? "D-Day" : "D-" . ( ( strtotime( $item->duedate ) - strtotime( date( 'Y-m-d' ) ) ) / ( 60 * 60 * 24 ) )?></li>
                                <?php } ?>
                                <li><a href="#"><i class="icon-picture"></i></a></li>
                            </ul>
                            <div class="entry-content">
                                <p><?php echo strip_tags( $item->_contents )?></p>
                                <a href="/<?php echo $ci->menu->current[0]['v']?>/article?s=<?php echo $item->source?>&k=<?php echo $item->external_key?>" class="more-link">Read More</a>
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