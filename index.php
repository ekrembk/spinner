<?php
/**
 * Thebestspinner Library test 
 *
 * @author Ekrem Büyükkaya <ebuyukkaya@gmail.com> <ekrembk.com>
 */

// Örnek kullanım
$spinner = new BestSpinner( 'This house is located in Ibiza and it was designed by Jaime Serra. It’s a sun-filled home with a modern and simple design. The residence was structured in three sections or volumes. In the center is the lounge area and everything else is structured starting from there. The property also has a 25 meter long and 3.5 meter wide swimming pool surrounded by vegetation.' );
echo $spinner->spin();