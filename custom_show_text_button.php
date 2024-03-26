<?php
/*

После этого активируйте плагин в административной панели WordPress.
Затем перейдите в раздел "Настройки" -> "Custom Show Text" и введите текст в текстовое поле.

*/

// Добавляем страницу настроек
add_action('admin_menu', 'custom_show_text_menu');
function custom_show_text_menu()
{
    add_options_page('Custom Show Text Settings', 'Custom Show Text', 'manage_options', 'custom-show-text', 'custom_show_text_options');
}

// Регистрируемся и добавляем настройки
add_action('admin_init', 'custom_show_text_settings');
function custom_show_text_settings()
{
    register_setting('custom-show-text-settings-group', 'custom_show_text');
}

// Отображение страницы настроек
function custom_show_text_options()
{
?>
    <div class="wrap">
        <h2>Custom Show Text Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('custom-show-text-settings-group'); ?>
            <?php do_settings_sections('custom-show-text-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Custom Text</th>
                    <td><input type="text" name="custom_show_text" value="<?php echo esc_attr(get_option('custom_show_text')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Добавляем кнопку для отображения пользовательского текста на всех страницах
add_action('wp_footer', 'custom_show_text_button');
function custom_show_text_button()
{
    $custom_text = get_option('custom_show_text');
    if (!empty($custom_text)) {
    ?>
        <script>
            jQuery(document).ready(function($) {
                $('body').append('<div class="block_show-custom-text"><button id="show-custom-text"><span>Показать текст</span></button></div>');
                $('#show-custom-text').click(function() {
                    $(this).remove();
                    $('body').append('<div class="block_show-custom-text__show"><?php echo addslashes($custom_text); ?></div>');
                });
            });
        </script>
<?php
    }
}

?>

<style>
    .block_show-custom-text {
        display: flex;
        justify-content: center;
        margin: 0 0 2em;
    }

    #show-custom-text {
        display: block;
        width: 200px;
        height: 45px;
        line-height: 40px;
        font-size: 18px;
        font-family: sans-serif;
        text-decoration: none;
        color: #333;
        letter-spacing: 2px;
        text-align: center;
        position: relative;
        transition: all .35s;
    }

    #show-custom-text span {
        position: relative;
        z-index: 2;
    }

    #show-custom-text:after {
        position: absolute;
        content: "";
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background: #ff003b;
        transition: all .35s;
    }

    #show-custom-text:hover {
        color: #fff;
    }

    #show-custom-text:hover:after {
        width: 100%;
    }
</style>
