    </div>
    <footer>
        <p>
            Fizzy.io &nbsp; 
            <span class="fa fa-reply"></span>
            &nbsp; <a href="/contact">Contact</a>
        </p>
    </footer>
    <script data-main="/javascript/requirejs.js" src="<?php echo ROOT_PATH . 'ext/require/require.js'; ?>"></script>
    <?php
        foreach($js as $file) {
            $path = 'javascript/pages/' . $file . '.js';
            $args = "$path?". filemtime($path);
            $fullPath = ROOT_PATH . $path;
        ?>
            <script src="<?php echo $fullPath; ?>"></script>
        <?php
        }
    ?>
</body>
</html>