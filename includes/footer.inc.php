<?php
include "conf.inc.php";
cerrarSeccionContenido();
?>
            <div id="footer">
                <div id="plataform">
                    <a href="http://yacomas.sourceforge.net/" target="_blank" title="Created with YACOMAS">
                        <img title="Created with YACOMAS" alt="YaCOMAS" src="<?php echo "$conference_link/images/buttons/yacomas-micro.png"; ?>" />
                    </a>
                    <a href="http://www.php.net/" target="blank" title="Pumped through PHP">
                        <img title="Pumped th/rough PHP" alt="PHP" src="<?php echo "$conference_link/images/buttons/php.png"; ?>" />
                    </a>
                    <a href="http://www.gnu.org/" target="blank" title="Fueled by GNU software">
                        <img title="Fueled by GNU software" alt="GNU" src="<?php echo "$conference_link/images/buttons/gnu-powered.png"; ?>" />
                    </a>
                    <a href="http://www.mysql.com/products/mysql/" target="blank" title="MySQL under the hood">
                        <img title="Fueled by GNU software" alt="GNU" src="<?php echo "$conference_link/images/buttons/mysql-power-micro.png"; ?>" />
                    </a>
                </div>
                <div class="elementocentrado">
<?php
if ( !empty ($copyright_author) )
    print "Copyright (c) ".date("Y")." - <a href=\"$conference_link\">$copyright_author</a>";
?>
                    <br> Powered by <a href="http://yacomas.sourceforge.net/" target="_blank"> Yacomas </a>
                    <a href="mailto:patux@patux.net">Report a bug</a><br>   
                </div>
            </div>
    <!--</div>-->
</div>
</body>
</html>

