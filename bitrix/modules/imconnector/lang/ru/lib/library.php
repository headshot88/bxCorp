<?php
$MESS['IMCONNECTOR_PROXY_NO_USER_IM'] = 'Не получен id пользователя мессенджера';
$MESS['IMCONNECTOR_PROXY_NO_ADD_USER'] = 'Не удалось создать или получить пользователя системы, сопоставленного с пользователем удаленного мессенджера';
$MESS['IMCONNECTOR_NOT_SPECIFIED_CORRECT_CONNECTOR'] = 'Не указан коннектор';
$MESS['IMCONNECTOR_NOT_SPECIFIED_CORRECT_COMMAND'] = 'Не указана корректная команда';
$MESS['IMCONNECTOR_NOT_ALL_THE_REQUIRED_DATA'] = 'Переданы не все необходимые данные';
$MESS['IMCONNECTOR_EMPTY_PARAMETRS'] = 'Переданы пустые параметры';
$MESS['IMCONNECTOR_NOT_AVAILABLE_CONNECTOR'] = 'Попытка обращения к несуществующему или не активному коннектору';
$MESS['IMCONNECTOR_FEATURE_IS_NOT_SUPPORTED'] = 'Данная возможность не поддерживается';
$MESS['IMCONNECTOR_ADD_EXISTING_CONNECTOR'] = 'Попытка добавления уже существующего коннектора';
$MESS['IMCONNECTOR_UPDATE_NOT_EXISTING_CONNECTOR'] = 'Попытка обновления, не активированного коннектора';
$MESS['IMCONNECTOR_DELETE_NOT_EXISTING_CONNECTOR'] = 'Попытка удаления, не активированного коннектора';
$MESS['IMCONNECTOR_FAILED_TO_ADD_CONNECTOR'] = 'Не удалось добавить коннектор открытой линии';
$MESS['IMCONNECTOR_FAILED_TO_UPDATE_CONNECTOR'] = 'Не удалось обновить коннектор открытой линии';
$MESS['IMCONNECTOR_FAILED_TO_DELETE_CONNECTOR'] = 'Не удалось удалить коннектор открытой линии';
$MESS['IMCONNECTOR_FAILED_TO_LOAD_MODULE_OPEN_LINES'] = 'Не удалось загрузить модуль открытых линий';
$MESS['IMCONNECTOR_FAILED_TO_SAVE_SETTINGS_CONNECTOR'] = 'Не удалось сохранить настройки коннектора';
$MESS['IMCONNECTOR_FAILED_TO_TEST_CONNECTOR'] = 'Не удалось протестировать соединение коннектора';
$MESS['IMCONNECTOR_FAILED_REGISTER_CONNECTOR'] = 'Не удалось зарегистрировать коннектор';
$MESS['IMCONNECTOR_NOT_ACTIVE_LINE'] = 'Линия c таким ID неактивна или не существует';

$MESS['IMCONNECTOR_REST_APPLICATION_REGISTRATION_ERROR'] = 'Ошибка регистрации приложения';
$MESS['IMCONNECTOR_REST_APPLICATION_REGISTRATION_ERROR_POINT'] = 'Ошибка регистрации приложения. В идентификаторе коннектора недопустимо использовать точку.';
$MESS['IMCONNECTOR_REST_APPLICATION_UNREGISTRATION_ERROR'] = 'Ошибка снятия регистрации приложения';
$MESS['IMCONNECTOR_REST_CONNECTOR_ID_REQUIRED'] = 'Не указан ID коннектора';
$MESS['IMCONNECTOR_REST_NAME_REQUIRED'] = 'Не указано имя коннектора';
$MESS['IMCONNECTOR_REST_ICON_REQUIRED'] = 'Не указана иконка коннектора';
$MESS['IMCONNECTOR_REST_NO_APPLICATION_ID'] = 'Не удалось получить ID приложения';
$MESS['IMCONNECTOR_REST_NO_PLACEMENT_HANDLER'] = 'Не удалось получить URL обработчика встраивания';
$MESS['IMCONNECTOR_REST_GENERAL_CONNECTOR_REGISTRATION_ERROR'] = 'Общая ошибка регистрации коннектора';

$MESS['IMCONNECTOR_ERROR_PROVIDER_NO_ACTIVE_CONNECTOR'] = 'Неактивный коннектор';
$MESS['IMCONNECTOR_ERROR_PROVIDER_CONTROLLER_CONNECTOR_URL'] = 'Некорректный адрес контроллера коннекторов';
$MESS['IMCONNECTOR_ERROR_PROVIDER_LICENCE_CODE_PORTAL'] = 'Некорректный лицензионный код портала';
$MESS['IMCONNECTOR_ERROR_PROVIDER_TYPE_PORTAL'] = 'Некорректный тип портала';
$MESS['IMCONNECTOR_ERROR_PROVIDER_CONNECTOR'] = 'Некорректный ID коннектора';
$MESS['IMCONNECTOR_ERROR_PROVIDER_LINE'] = 'Некорректный ID линии';
$MESS['IMCONNECTOR_ERROR_PROVIDER_NOT_CALL'] = 'Нет возможности вызвать метод';
$MESS['IMCONNECTOR_ERROR_INCORRECT_INCOMING_DATA'] = 'Не корректные входящие данные';
$MESS['IMCONNECTOR_ERROR_NO_CORRECT_PROVIDER'] = 'Не удалось найти подходящий провайдер для коннектора';
$MESS['IMCONNECTOR_ERROR_PROVIDER_GENERAL_REQUEST_NOT_DYNAMIC_METHOD'] = 'Попытка вызвать статический метод динамически';
$MESS['IMCONNECTOR_ERROR_PROVIDER_GENERAL_REQUEST_DYNAMIC_METHOD'] = 'Попытка вызвать динамический метод статически';
$MESS['IMCONNECTOR_ERROR_COULD_NOT_GET_PROVIDER_OBJECT'] = 'Не удалось получить объект провайдера';
$MESS['IMCONNECTOR_ERROR_PROVIDER_DOES_NOT_SUPPORT_THIS_METHOD_CALL'] = 'Данный провайдер не поддерживает подобный вариант вызова';
$MESS['IMCONNECTOR_ERROR_PROVIDER_UNSUPPORTED_TYPE_INCOMING_MESSAGE'] = 'Неподдерживаемый тип входящего сообщения от серввера.';

$MESS['IMCONNECTOR_ERROR_PUBLIC_URL_EMPTY'] = "В настройках модуля \"Коннекторы для внешних мессенджеров\" необходимо указать публичный адрес сайта";
$MESS['IMCONNECTOR_ERROR_PUBLIC_URL_MALFORMED'] = "Указан некорректный публичный адрес сайта";
$MESS['IMCONNECTOR_ERROR_PUBLIC_URL_LOCALHOST'] = "Публичный адрес сайта указывает на локальный хост: #HOST#";
$MESS['IMCONNECTOR_ERROR_CONVERTING_PUNYCODE'] = "Ошибка преобразования имени хоста #HOST# в Punycode: #ERROR#";
$MESS['IMCONNECTOR_ERROR_PUBLIC_URL_HANDLER_PATH'] = "Файл обработчик в публичной части сайта не найден. Необходимо наличие: #PATH#";
$MESS['IMCONNECTOR_ERROR_NETWORK_ERROR'] = "Ошибка сетевого соединения";
$MESS['IMCONNECTOR_ERROR_ANSWER_MALFORMED'] = "Получен ответ сервера не в JSON формате";
$MESS['IMCONNECTOR_ERROR_PUBLIC_URL_CONNECT_ERROR'] = "Ошибка проверки публичного адреса сайта: соединение не установлено";
$MESS['IMCONNECTOR_ERROR_PUBLIC_URL_WRONG_ANSWER_CODE'] = "Ошибка проверки публичного адреса сайта: неправильный http код ответа сервера";
$MESS['IMCONNECTOR_ERROR_PUBLIC_URL_ANSWER_MALFORMED'] = "Ошибка проверки публичного адреса сайта: нераспознаваемый ответ сервера";
$MESS['IMCONNECTOR_ERROR_PUBLIC_URL_WRONG_ANSWER'] = "Ошибка проверки публичного адреса сайта: неправильный ответ сервера";
$MESS['IMCONNECTOR_ERROR_PUBLIC_URL_FAIL'] = "Указанный публичный адрес сайта не доступен (код: #ERROR#)";
$MESS['IMCONNECTOR_ERROR_LICENCE_ERROR'] = "Лицензия указанного сайта недействительна";
$MESS['IMCONNECTOR_ERROR_NO_DOMAIN'] = "Не задан домен портала клиента";
$MESS['IMCONNECTOR_ERROR_NO_RESPONSE'] = 'Получен пустой ответ от портала клиента';
