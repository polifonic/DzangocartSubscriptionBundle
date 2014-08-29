
/**
 * add validation constraint NotNull to <?php echo $plan_id_column ?>.
 */

public static function loadValidatorMetadata(ClassMetadata $metadata)
{
    $metadata->addPropertyConstraint(
        '<?php echo $plan_id_column ?>',
        new NotNull(array(
            'message' => 'validation.error.plan.null'
        ))
    );
}
