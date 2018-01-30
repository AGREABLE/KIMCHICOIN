


<!-- Footer
============================================= -->
<footer id="footer" class="dark">

    <!-- Copyrights
    ============================================= -->
    <div id="copyrights">

        <div class="container clearfix">

            <div class="col_half">
                Copyrights &copy; 2018 All Rights Reserved by <?php echo $ci->config->item( 'service_name' )?> Inc.
                <br/>
                <a class="pointer" onclick="changeLang('en')">English</a>
                |
                <a class="pointer" onclick="changeLang('ko')">한국어</a>
            </div>

            <div class="col_half col_last tright">
                <div class="fright clearfix">
                    <a href="#" class="social-icon si-small si-borderless si-twitter">
                        <i class="icon-twitter"></i>
                        <i class="icon-twitter"></i>
                    </a>
                </div>

                <div class="clear"></div>

                <i class="icon-envelope2"></i> <?php echo $ci->config->item( 'support' )?>
            </div>

        </div>

    </div><!-- #copyrights end -->

</footer><!-- #footer end -->

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>

<!-- Footer Scripts
============================================= -->
<script type="text/javascript" src="/assets/canvas/js/functions.js"></script>


<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay_progress.min.js"></script>

<script>
    var changeLang = function( lang ) {
        setCookie( 'lang', lang, 365 );
        window.location = window.location;
    }
</script>

</body>
</html>