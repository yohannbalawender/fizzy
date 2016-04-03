
        <footer>
            <div>
                <p>
                    <span class="fa fa-reply"></span>
                    <a href="/contact">Contact</a>
                </p>
                <p>© 2016 Fizzy.io, All Rights Reserved.</p>
            </div>
        </footer>
        <script data-main="javascript/requirejs.js" src="javascript/ext/require/require.js"></script>
        <?php
            foreach($js as $file) {
                $path = 'javascript/pages/' . $file . '.js';
                $fullPath = "$path?". filemtime($path);

            ?>
                <script src="<?php echo $fullPath; ?>"></script>
            <?php
            }
        ?>
    </body>
</html>