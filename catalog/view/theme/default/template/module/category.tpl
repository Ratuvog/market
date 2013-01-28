<div class="row-fluid categoris">
    <?php foreach ($categories as $category) { ?>
    <div class="span2 categor-item">
        <a href="<?=$category['href'];?>"><table width="100%">
                <tr>
                    <td class="categor-item-img" align="center"><img src="/catalog/view/theme/default/image/creatin.png" alt="Креатин" /></td>
                </tr>
                <tr>
                    <td class="categor-item-name" align="center">
                        <?=$category['name'];?>
                    </td>
                </tr>
            </table>
        </a>
    </div>
    <? } ?>

</div>
