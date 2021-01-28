<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'wpclubmanager_admin_before_lineup_stats_head', 'wpcm_cricket_match_lineup_head' );
add_action( 'wpclubmanager_admin_before_lineup_stats', 'wpcm_cricket_match_lineup', 10, 3 );

function wpcm_cricket_match_lineup_head() { ?>

    <th class="out"></th>
<?php
}

function wpcm_cricket_match_lineup( $players = array(), $id = null, $disabled = false ) { 

    $outs = wpcm_cricket_outs(); ?>

    <td class="out">
        <select name="wpcm_players[lineup][<?php echo $id; ?>][out]" class="postform" <?php disabled( true, $disabled ); ?>>

            <?php foreach( $outs as $key => $value ) { ?>

                <option value="<?php echo $key; ?>"<?php echo ( $key == get_wpcm_stats_value( $players['lineup'], $id, 'out' ) ? ' selected' : '' ); ?>><?php echo $value; ?></option>

            <?php } ?>

        </select>
    </td>
<?php
}