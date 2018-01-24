
<link href="/assets/plugins/switchery/switchery.min.css" rel="stylesheet">
<script src="/assets/plugins/switchery/switchery.min.js"></script>

<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <!-- Post Content
            ============================================= -->
            <div class="nobottommargin clearfix">
                <div class="table-responsive">
                    <table class="table table-hover valign-m">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>노출</th>
                            <th>SOURCE</th>
                            <th>TITLE</th>
                            <th>LINK</th>
                            <th>작성일시</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ( $i = 0; $i < count( $data->lists ); $i++ ) {
                            $item = $data->lists[$i];
                            ?>
                            <tr>
                                <td><?php echo $data->total - $params['offset'] - $i?></td>
                                <td><input type="checkbox" class="js-switch isrelease-onoff" data-source="<?php echo $item->source?>" data-external_key="<?php echo $item->external_key?>" value="1" <?php echo ( $item->is_release == 'A' ) ? "checked" : ""?>/></td>
                                <td><?php echo  $item->source?></td>
                                <td><a href="/<?php echo $cname?>/modify/<?php echo $item->source?>/<?php echo $item->external_key?>"><?php echo  $item->title?></a></td>
                                <td><a href="<?php echo $item->link?>" target="_blank">LINK</a></td>
                                <td><?php echo  $item->created_at?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

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

</section>



<script>

    $(document).ready( function() {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html, { size: 'small' });
        });

        $('.isrelease-onoff').change( function() {
            var is_release = ( $(this)[0].checked ) ? 'A' : 'D';
            $.post( '/<?php echo $cname?>/ajaxUpdateIsRelease', {source:$(this).data('source'),external_key:$(this).data('external_key')
                ,is_release:is_release}, function( data ) {
                var result = JSON.parse( data );
                if ( result.error_code == 200 ) {
                    ;
                } else
                    location.reload();
            });
        });
    });

</script>