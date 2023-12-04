<?
require($_SERVER[ "DOCUMENT_ROOT" ]."/bitrix/header.php");
$APPLICATION->SetTitle("Создание нового события");

use Bitrix\Crm\Category\DealCategory;

?>
    <style>
        #content_main h3 {
            padding: 34px 0;
            font-size: 15px;
            color: #525c69;
            line-height: 17px;
            font-weight: 800;
        }

        .tabs {
            display: grid;
        }

        [role=tablist] {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            grid-gap: 10px;
        }

        .tabWrapper {
            display: grid;
        }

        [role=tabpanel] {
            background: #f8f9fa;
        }

        button {
            background: #ffffff;
            border: 0;
            border-radius: 5px 5px 0 0;
            cursor: pointer;
            height: 50px;
            font-family: var(--mib-item-font-family);
            font-size: var(--mib-item-font-size);
            font-weight: 500;
            color: var(--mib-item-color);
        }

        button[aria-selected=true] {
            background: #f8f9fa;
            color: #000000;


        }

        button:focus {
            box-shadow: 0 0 0 4px rgba(21, 156, 228, 0.7);
            outline: none;
            z-index: 5;
        }
    </style>

    <div id="content_main">
        <div class="content">
            <div class="tabWrapper">
                <div class="tabs">
                    <div role="tablist" aria-label="tabs">
                        <button role="tab" aria-selected="true" id="tab-1">Построение условий работы</button>
                        <button role="tab" aria-selected="false" id="tab-2">Отправка - "Telegram"</button>
                        <button role="tab" aria-selected="false" id="tab-3">Отправка - "Почта"</button>
                        <button role="tab" aria-selected="false" id="tab-4">Отправка - "Bitrix24"</button>
                    </div>
                    <div role="tabpanel" aria-labelledby="tab-1">
                        <div class="ui-form ui-form-section">
                            <div class="ui-form ui-form-section">
                                <h3>Построение условий работы</h3>

                                <div class="ui-form">
                                    <div class="ui-form-row-inline">
                                        <div class="ui-form-row">
                                            <div class="ui-form-label">
                                                <div class="ui-ctl-label-text">Дата и время начала</div>
                                            </div>
                                            <div class="ui-form-content">
                                                <div class="ui-ctl ui-ctl-after-icon ui-ctl-date">
                                                    <div class="ui-ctl-after ui-ctl-icon-calendar"></div>
                                                    <div class="ui-ctl-element">14.10.2014</div>
                                                </div>
                                                <div class="ui-ctl ui-ctl-after-icon ui-ctl-dropdown">
                                                    <div class="ui-ctl-after ui-ctl-icon-angle"></div>
                                                    <select class="ui-ctl-element">
                                                        <option value="">12:00</option>
                                                        <option value="">13:00</option>
                                                        <option value="">14:00</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ui-form-row">
                                            <div class="ui-form-label">
                                                <div class="ui-ctl-label-text">Длительность</div>
                                            </div>
                                            <div class="ui-form-content">
                                                <div class="ui-ctl ui-ctl-textbox">
                                                    <input type="text" class="ui-ctl-element" placeholder="">
                                                </div>
                                                <div class="ui-ctl ui-ctl-after-icon ui-ctl-dropdown">
                                                    <div class="ui-ctl-after ui-ctl-icon-angle"></div>
                                                    <select class="ui-ctl-element">
                                                        <option value="">часов</option>
                                                        <option value="">минут</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ui-form-row">
                                            <div class="ui-form-label">
                                                <div class="ui-ctl-label-text">Дата и время завершения</div>
                                            </div>
                                            <div class="ui-form-content">
                                                <div class="ui-ctl ui-ctl-after-icon ui-ctl-date">
                                                    <div class="ui-ctl-after ui-ctl-icon-calendar"></div>
                                                    <div class="ui-ctl-element">14.10.2019</div>
                                                </div>
                                                <div class="ui-ctl ui-ctl-after-icon ui-ctl-dropdown">
                                                    <div class="ui-ctl-after ui-ctl-icon-angle"></div>
                                                    <select class="ui-ctl-element">
                                                        <option value="">12:00</option>
                                                        <option value="">13:00</option>
                                                        <option value="">14:00</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="menu-popup">
                                    <div class="menu-popup-items"><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#22b9ff"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">Новая задача</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#10e5fc"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">В планах (ИДЕИ)</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#a5de00"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">Пауза</span><div
                                                            class="bizproc-creating-robot__stage-block_selected"></div></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#eec200"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">Требуется доработка</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#ffa801"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">Есть вопросы</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#555555"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">Очередь</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#000000"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">В работе</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#ff5752"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">Ревью</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#f10057"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">Тестирование</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#1eae43"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">Деплой</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#00c4fb"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">На бою или задача готова</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#47d1e2"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">Не актуально</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#6b52cc"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">Заморозка</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#ffffff"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">КОНЕЦ</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#00ff00"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">Успех</span></div></span></span><span
                                                class="menu-popup-item menu-popup-no-icon "><span
                                                    class="menu-popup-item-icon"></span><span
                                                    class="menu-popup-item-text"><div
                                                        class="bizproc-creating-robot__stage-block_title-menu"><svg
                                                            class="bizproc-creating-robot__stage-block_color" width="14"
                                                            height="12" viewBox="0 0 13 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            data-role="bp-robot-selector-stage-block-color-block"><path
                                                                fill="#ff0000"
                                                                d="M0 2.25C0 1.00736 1.02835 0 2.29689 0H8.68575C9.25708 0 9.80141 0.20818 10.2184 0.574156C10.465 0.790543 10.6254 1.08387 10.7737 1.37649L12.6727 5.12357C12.7468 5.26988 12.8412 5.40624 12.9071 5.55648C13.031 5.83933 13.031 6.16066 12.9071 6.44352C12.8412 6.59376 12.7468 6.73012 12.6727 6.87643L10.7737 10.6235C10.6254 10.9161 10.465 11.2095 10.2184 11.4258C9.80141 11.7918 9.25708 12 8.68575 12L2.29689 12C1.02835 12 0 10.9926 0 9.75V2.25Z"></path></svg><span
                                                            class="bizproc-creating-robot__stage-block_title-text-menu">Провал</span></div></span></span>
                                    </div>
                                </div>


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
                                                <input type="text" class="ui-ctl-element"
                                                       placeholder="Название тестового чата">
                                            </div>
                                        </div>
                                        <div class="ui-form-row">
                                            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                                                <input type="text" class="ui-ctl-element"
                                                       placeholder="ID тестового чата">
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
                    </div>
                    <div role="tabpanel" aria-labelledby="tab-2" hidden>
                        <div class="ui-form ui-form-section">
                            <div class="ui-form ui-form-section">
                                <h3>Отправка - "Telegram"</h3>

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
                                                <input type="text" class="ui-ctl-element"
                                                       placeholder="Название тестового чата">
                                            </div>
                                        </div>
                                        <div class="ui-form-row">
                                            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                                                <input type="text" class="ui-ctl-element"
                                                       placeholder="ID тестового чата">
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
                    </div>
                    <div role="tabpanel" aria-labelledby="tab-3" hidden>
                        <div class="ui-form ui-form-section">
                            <div class="ui-form ui-form-section">
                                <h3>Отправка - "Почта"</h3>

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
                                                <input type="text" class="ui-ctl-element"
                                                       placeholder="Название тестового чата">
                                            </div>
                                        </div>
                                        <div class="ui-form-row">
                                            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                                                <input type="text" class="ui-ctl-element"
                                                       placeholder="ID тестового чата">
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
                    </div>
                    <div role="tabpanel" aria-labelledby="tab-4" hidden>
                        <div class="ui-form ui-form-section">
                            <div class="ui-form ui-form-section">
                                <h3>Отправка - "Bitrix24"</h3>

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
                                                <input type="text" class="ui-ctl-element"
                                                       placeholder="Название тестового чата">
                                            </div>
                                        </div>
                                        <div class="ui-form-row">
                                            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                                                <input type="text" class="ui-ctl-element"
                                                       placeholder="ID тестового чата">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const tabs = document.querySelector('.tabs');
        const tabButtons = tabs.querySelectorAll('[role="tab"]');
        const tabPanels = tabs.querySelectorAll('[role="tabpanel"]');

        function handleTabClick(event) {
            tabPanels.forEach(function (panel) {
                panel.hidden = true;
            });

            tabButtons.forEach(function (tab) {
                tab.setAttribute('aria-selected', false);
            });

            event.currentTarget.setAttribute('aria-selected', true);

            const {id} = event.currentTarget;

            const tabPanel = tabs.querySelector(`[aria-labelledby="${id}"]`);
            tabPanel.hidden = false;
        }

        tabButtons.forEach(button => button.addEventListener('click', handleTabClick));
    </script>

    <script>
        const catalog = new EntityCatalog({
            groups: [],
            items: [
                {
                    id: 'item-1',
                    title: 'Первый элемент',
                    groupIds: ['recent'],
                },
                {
                    id: 'item-2',
                    title: 'Второй элемент',
                    groupIds: ['recent'],
                },
                {
                    id: 'item-3',
                    title: 'Третий элемент',
                    groupIds: ['recent'],
                },
            ],
            showRecentGroup: true,
        });
        catalog.show();
    </script>

<? require($_SERVER[ "DOCUMENT_ROOT" ]."/bitrix/footer.php"); ?>