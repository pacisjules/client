<?php
                        require_once 'functions/connection.php';
                      

                        //Get product expiration time
                        $sqlExpiry = "SELECT `expired_time`, `allow_exp` FROM `products` WHERE `id` = 7481";
                        $result = $conn->query($sqlExpiry);
                        $rowInfos = $result->fetch_assoc();
                        $hours_of_expiry = $rowInfos['expired_time'];
                        $allow_exp = $rowInfos['allow_exp'];
                        echo 'Time now: ' . date('Y-m-d H:i:s') . '<br/>';
                        echo $hours_of_expiry . '<br/>';
                        echo $allow_exp . '<br/>';

                        //Add this now time to expiry time
                        $expiry_date = date('Y-m-d H:i:s', strtotime('+' . $hours_of_expiry . ' hours', strtotime(date('Y-m-d H:i:s'))));

                        echo $expiry_date;

                        if ($allow_exp == 1) {
                            echo 'Allow expiry';
                        }
                        
?>