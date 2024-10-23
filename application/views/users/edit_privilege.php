<input type="hidden" value="<?php echo $id ?>" id="privilege_user_id"/>
<table width="98%" border="1" style="margin:5px;border-collapse: collapse;" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th width="35%" align="center">Menu</th>
            <th width="65%" align="center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($menu as $result) {
            $checked_menu = "";
            $disable_action = "disabled";
            $user_action = array();
            if (!empty($result->usersid)) {
                $checked_menu = "checked";
                $disable_action = "";
                $user_action = explode('|', $result->menuuser_actions);
            }

            $explode_list_action = explode('|', $result->actions);
            ?>
            <tr valign="top">
                <td><input type="checkbox" <?php echo $checked_menu ?> style="padding: 0px;height: 15px" id='menu<?php echo $result->id ?>'  value="<?php echo $result->id ?>" onclick="user_privilege_click_menu('menu<?php echo $result->id ?>',<?php echo count($explode_list_action) ?>)"/></td>
                <td style="padding: 2px"><?php echo $result->label ?></td>
                <td>
                    <?php
//                    print_r($user_action);
                    if (!empty($result->actions)) {
                        for ($i = 0; $i < count($explode_list_action); $i++) {
                            $checked = "";
                            if (count($user_action) > 0) {
                                if (in_array($explode_list_action[$i], $user_action)) {
                                    $checked = "checked";
                                }
                            }
                            ?>
                            <span style="padding: 2px;display: inline-block;">
                                <input type="checkbox" <?php echo $checked . " " . $disable_action ?> id='menuaction<?php echo $result->id . $i ?>' onclick="user_action_set(this, '<?php echo $result->id; ?>')" style="padding: 0px;height: 15px;vertical-align: middle;" id="<?php echo $result->id . $i ?>" value="<?php echo $explode_list_action[$i] ?>"/><?php echo $explode_list_action[$i] ?>
                            </span>
                            <?php
                        }
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>