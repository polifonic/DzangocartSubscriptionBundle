
/**
 * Whether the subscription is currently during a trial period
 *
 * @boolean true if the subscription is during a trial period, false otherwise
 */
public function isTrial()
{
    $expire = $this->get<?php echo $column_name ?>('U');

    return ($expire != null && $expire < time());
}
