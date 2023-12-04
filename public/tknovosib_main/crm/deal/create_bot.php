<?
require($_SERVER[ "DOCUMENT_ROOT" ]."/bitrix/header.php");
$APPLICATION->SetTitle("Соединиться с новым telegram ботом");
\Bitrix\Main\UI\Extension::load("ui.hint");
?>
    <style>
        /*#workarea-content {
            -webkit-backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, .2);
        }*/

        .crm-entity-card-container {
            float: left;
            box-sizing: border-box;
            width: 41.6%;
        }
    </style>

    <div class="crm-entity-card-container">
        <form name="bot_details_editor_form" onsubmit="return false;">
            <div class="ui-form ui-form-section">
                <div class="ui-form ui-form-section">

                    <div class="ui-form-row">
                        <div class="ui-form-label">
                            <div class="ui-ctl-label-text">Название бота</div>
                        </div>
                        <div class="ui-form-content">
                            <div class="ui-form-row">
                                <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                                    <input type="text" class="ui-ctl-element" placeholder="Название бота">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui-form-row">
                        <div class="ui-form-label">
                            <div class="ui-ctl-label-text">Токен бота</div>
                        </div>
                        <div class="ui-form-content">
                            <div class="ui-form-row">
                                <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                                    <input type="text" class="ui-ctl-element" placeholder="Название бота">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui-form-row">
                        <div class="ui-form-label">
                            <div class="ui-ctl-label-text">Обработка текста</div>
                        </div>
                        <div class="ui-form-content">
                            <div class="ui-form-row">
                                <div class="ui-ctl ui-ctl-after-icon ui-ctl-w100 ui-ctl-dropdown">
                                    <div class="ui-ctl-after ui-ctl-icon-angle"></div>
                                    <select class="ui-ctl-element">
                                        <option value="markdown">Markdown</option>
                                        <option value="markdown">Markdown</option>
                                        <option value="markdown">Markdown</option>
                                        <option value="markdown">Markdown</option>
                                        <option value="markdown">Markdown</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui-form-row">
                        <div class="ui-form-label">
                            <div class="ui-ctl-label-text">Тест telegram</div>
                        </div>
                        <div class="ui-form-content">
                            <div class="ui-form-row">
                                <label class="ui-ctl ui-ctl-checkbox ui-ctl-w100">
                                    <input type="checkbox" class="ui-ctl-element">
                                    <div class="ui-ctl-label-text">перенаправлять все письма в чат</div>
                                </label>
                            </div>
                            <div class="ui-form-row">
                                <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                                    <input type="text" class="ui-ctl-element" placeholder="Название тестового чата">
                                </div>
                            </div>
                            <div class="ui-form-row">
                                <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                                    <input type="text" class="ui-ctl-element" placeholder="ID тестового чата">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui-form-row">
                        <div class="ui-form-label">
                            <div class="ui-ctl-label-text">Комментарий</div>
                        </div>
                        <div class="ui-form-content">
                            <div class="ui-form-row">
                                <div class="ui-ctl ui-ctl-textarea ui-ctl-w100 ui-ctl-no-resize">
                                    <textarea class="ui-ctl-element"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


<? require($_SERVER[ "DOCUMENT_ROOT" ]."/bitrix/footer.php"); ?>