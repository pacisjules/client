<?php
                        require_once 'functions/connection.php';
                        echo 'Now: ' . date('Y-m-d H:i:s') . '<br/>';


                        $sqlExpiry = "SELECT `exp_id`, `product_id`, `quantity`, `user_id`, `status`, `due_date`, `created_at` FROM `expiration_table` WHERE 1";
                        $result = $conn->query($sqlExpiry);
                        while ($rowExpiry = $result->fetch_assoc()) {
                            echo '<br/>';
                            echo 'Exp_id: ' . $rowExpiry['exp_id'] . '<br/>';
                            echo 'Product_id: ' . $rowExpiry['product_id'] . '<br/>';
                            echo 'Quantity: ' . $rowExpiry['quantity'] . '<br/>';
                            echo 'User_id: ' . $rowExpiry['user_id'] . '<br/>';
                            echo 'Status: ' . $rowExpiry['status'] . '<br/>';
                            echo 'Due_date: ' . $rowExpiry['due_date'] . '<br/>';
                            echo 'Created_at: ' . $rowExpiry['created_at'] . '<br/>';

                            //Calculate remain time
                            $due_date = $rowExpiry['due_date'];
                            $now = date('Y-m-d H:i:s');
                            $diff = strtotime($due_date) - strtotime($now);
                            $remain_day = round($diff / (60 * 60 * 24));
                            $remain_hour = round(($diff - $remain_day * 60 * 60 * 24) / (60 * 60));
                            $remain_minutes = round(($diff - $remain_day * 60 * 60 * 24 - $remain_hour * 60 * 60) / 60);
                            echo 'Remain day: ' . $remain_day . '<br/>';
                            echo 'Remain hour: ' . $remain_hour . '<br/>';
                            echo 'Remain minutes: ' . $remain_minutes . '<br/>';
                        }
?>