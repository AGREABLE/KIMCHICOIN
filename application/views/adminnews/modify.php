
<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="row clearfix">
                <form class="nobottommargin ajaxform" action="/<?php echo $cname?>/update" method="post">
                    <input type="hidden" name="source" value="<?php echo $one->source?>" />
                    <input type="hidden" name="external_key" value="<?php echo $one->external_key?>" />

                    <div class="col-md-6">
                        <h3>English</h3>

                        <div class="col_full">
                            <label for="title">제목</label>
                            <input type="text" id="title" name="title" value="<?php echo $one->title?>" class="sm-form-control" />
                        </div>

                        <div class="col_full">
                            <label for="contents">본문</label>
                            <textarea id="contents" name="contents" class="sm-form-control" rows="10"><?php echo strip_tags( $one->contents )?></textarea>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <h3>한글</h3>

                        <div class="col_full">
                            <label for="title_kr">제목</label>
                            <input type="text" id="title_kr" name="title_kr" value="<?php echo $one->title_kr?>" class="sm-form-control" />
                        </div>

                        <div class="col_full">
                            <label for="contents_kr">본문</label>
                            <textarea id="contents_kr" name="contents_kr" class="sm-form-control" rows="10"><?php echo strip_tags( $one->contents_kr )?></textarea>
                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="col_full">
                            <label for="link">LINK</label>
                            <input type="text" id="link" name="link" value="<?php echo $one->link?>" class="sm-form-control" />
                        </div>

                        <div class="col_full">
                            <label for="is_release">노출</label>
                            <select id="is_release" name="is_release" class="sm-form-control">
                                <option value="D" <?php echo ( $one->is_release == "D" ) ? "selected" : "" ?>>비활성화</option>
                                <option value="A" <?php echo ( $one->is_release == "A" ) ? "selected" : "" ?>>활성화</option>
                            </select>
                        </div>

                        <div class="col_full">
                            <label>작성일시 : <?php echo $one->created_at?></label>
                        </div>

                    </div>

                    <div>
                        <button class="button button-3d fright">저장</button>
                    </div>

                </form>

            </div>

            </div>

        </div>

    </div>

</section>