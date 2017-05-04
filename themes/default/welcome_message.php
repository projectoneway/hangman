
            <a href="<?php echo getLanguageSwitchUri(); ?>en">en</a>&nbsp;<a href="<?php echo getLanguageSwitchUri(); ?>fr">fr</a>
            
            
            
            <?php
            echo "<br/>";echo "<br/>";
            
             echo dateTimeFormat('2016-08-10 23:23'); echo "<br/>";echo "<br/>";echo "<br/>";
            
           
             //setlocale(LC_MONETARY, 'en_GB');
             echo moneyFormat('%i','123456.78'); echo "<br/>";echo "<br/>";echo "<br/>";
             echo moneyFormat('%n','123456.78'); echo "<br/>";echo "<br/>";echo "<br/>";
             
             ?>
		