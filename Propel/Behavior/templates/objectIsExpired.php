
 /**
 * Whether the subscription is expired
 *
 * @boolean true if the subscription is expired, false otherwise
 */
public function isExpired()
{
    $expire = $this->get<?php echo $column_name ?>('U');

    return ( $expire != null && $expire < time());
}

