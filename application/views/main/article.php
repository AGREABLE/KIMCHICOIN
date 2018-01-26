<script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>

<!-- Content
		============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="single-post nobottommargin">

                <!-- Single Post
                ============================================= -->
                <div class="entry clearfix">

                    <!-- Entry Title
                    ============================================= -->
                    <div class="entry-title">
                        <h2><?php echo $one->_title?></h2>
                    </div><!-- .entry-title end -->

                    <!-- Entry Meta
                    ============================================= -->
                    <ul class="entry-meta clearfix">
                        <li><i class="icon-calendar3"></i> <?php echo $one->created_at?></li>
                        <li><i class="icon-folder-open"></i> <?php echo $one->source?></li>
                        <li><a href="#"><i class="icon-picture"></i></a></li>
                    </ul><!-- .entry-meta end -->

                    <!-- Entry Image
                    ============================================= -->
                    <div class="entry-image bottommargin">
                        <img src="<?php echo $one->img?>">
                    </div><!-- .entry-image end -->

                    <!-- Entry Content
                    ============================================= -->
                    <div class="entry-content notopmargin">

                        <div>
                            <?php echo str_replace( ".", ".<br/><br/>", $one->_contents )?>
                        </div>
                        <div style="margin-top:80px;">
                            source : <a href="<?php echo $one->link?>" target="_blank"><?php echo $one->link?></a>
                        </div>
                        <!-- Post Single - Content End -->

                        <div class="clear"></div>

                        <!-- Post Single - Share
                        ============================================= -->
                        <div class="si-share noborder clearfix hide">
                            <span>Share this Post:</span>
                            <div>
                                <a href="#" class="social-icon si-borderless si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>
                                <a href="#" class="social-icon si-borderless si-twitter">
                                    <i class="icon-twitter"></i>
                                    <i class="icon-twitter"></i>
                                </a>
                                <a href="#" class="social-icon si-borderless si-pinterest">
                                    <i class="icon-pinterest"></i>
                                    <i class="icon-pinterest"></i>
                                </a>
                                <a href="#" class="social-icon si-borderless si-gplus">
                                    <i class="icon-gplus"></i>
                                    <i class="icon-gplus"></i>
                                </a>
                                <a href="#" class="social-icon si-borderless si-rss">
                                    <i class="icon-rss"></i>
                                    <i class="icon-rss"></i>
                                </a>
                                <a href="#" class="social-icon si-borderless si-email3">
                                    <i class="icon-email3"></i>
                                    <i class="icon-email3"></i>
                                </a>
                            </div>
                        </div><!-- Post Single - Share End -->

                    </div>
                </div><!-- .entry end -->

                <!-- Post Navigation
                ============================================= -->
                <div class="post-navigation clearfix">

                    <div class="col_half nobottommargin">
                    <?php if ( $prev ) { ?>
                        <a href="?s=<?php echo $prev->source?>&k=<?php echo $prev->external_key?>">&lArr; <?php echo $prev->_title?></a>
                    <?php } else { echo "<a>&nbsp;</a>"; }?>
                    </div>

                    <div class="col_half col_last tright nobottommargin">
                    <?php if ( $next ) { ?>
                        <a href="?s=<?php echo $next->source?>&k=<?php echo $next->external_key?>"><?php echo $next->_title?> &rArr;</a>
                    <?php } else { echo "<a>&nbsp;</a>"; }?>
                    </div>

                </div><!-- .post-navigation end -->

                <!-- Comments
                ============================================= -->
                <div id="comments" class="clearfix">

                    <h3 id="comments-title"><span><?php echo count( $data->comments )?></span> Comments</h3>

                    <!-- Comments List
                                                ============================================= -->
                    <ol class="commentlist clearfix">

                        <?php
                        for ( $i = 0; $i < count( $data->comments ); $i++ ) {
                        $item = $data->comments[$i];
                        ?>
                        <li class="comment even thread-even depth-1" id="li-comment-<?php echo $item->idx?>">

                            <div id="comment-1" class="comment-wrap clearfix">

                                <div class="comment-meta">

                                    <div class="comment-author vcard">
                                        <span class="comment-avatar clearfix">
                                        <img alt='' src='http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60' class='avatar avatar-60 photo avatar-default' height='60' width='60' /></span>
                                    </div>

                                </div>

                                <div class="comment-content clearfix">

                                    <div class="comment-author">ADMIN<span><a href="#" title="Permalink to this comment"><?php echo $item->created_at?></a></span></div>

                                    <?php echo $item->_contents?>

                                    <?php if ( $ci->menu->accountType == $ci->menu->ACCOUNT_SYSTEM_MANAGER ) { ?>
                                    <a class='comment-reply-link pointer' onclick="deleteComment(<?php echo $item->idx?>)"><i class="icon-trash"></i></a>
                                    <?php } ?>

                                </div>

                                <div class="clear"></div>

                            </div>

                        </li>
                        <?php }?>

                    </ol><!-- .commentlist end -->

                    <div class="clear"></div>

                <?php if ( $ci->menu->accountType == $ci->menu->ACCOUNT_SYSTEM_MANAGER ) { ?>

                    <!-- Comment Form
                    ============================================= -->
                    <div id="respond" class="clearfix">

                        <h3>Leave a <span>Comment</span></h3>

                        <form class="clearfix ajaxform" action="/main/ajaxWriteComment" method="post" id="commentform">
                            <input type="hidden" name="board_source" value="<?php echo $one->source?>" />
                            <input type="hidden" name="board_external_key" value="<?php echo $one->external_key?>" />

                            <div class="col-md-6">
                                <label for="contents">Comment English</label>
                                <textarea name="contents" id="contents" cols="58" rows="7" tabindex="4" class="sm-form-control"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="contents">Comment 한글</label>
                                <textarea name="contents_kr" id="contents_kr" cols="58" rows="7" tabindex="4" class="sm-form-control"></textarea>
                            </div>

                            <div class="clear"></div>

                            <div class="col-md-12 nobottommargin" style="margin-top: 30px;">
                                <button name="submit" type="submit" id="submit-button" tabindex="5" value="Submit" class="button button-3d nomargin" onclick="$('#contents').val(CKEDITOR.instances['contents'].getData());$('#contents_kr').val(CKEDITOR.instances['contents_kr'].getData());">Submit Comment</button>
                            </div>

                        </form>

                    </div><!-- #respond end -->

                <?php } ?>

                </div><!-- #comments end -->

            </div>

        </div>

    </div>

</section><!-- #content end -->


<script>

    CKEDITOR.replace( 'contents', {
        height: 400,
        filebrowserUploadUrl: '/main/upload'
    } );
    CKEDITOR.replace( 'contents_kr', {
        height: 400,
        filebrowserUploadUrl: '/main/upload'
    } );

    <?php if ( $ci->menu->accountType == $ci->menu->ACCOUNT_SYSTEM_MANAGER ) { ?>
    var deleteComment = function( idx ) {
        if ( confirm( '삭제하시겠습니까?' ) ) {
            $.post( '/main/ajaxDeleteComment', {idx:idx}, function( data ) {
               data = JSON.parse( data );
               if ( data.error_code == 200 )
                   location.reload();
               else
                   alert( data.error_msg );
            });
        }
    }
    <?php } ?>

</script>