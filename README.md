## Задание

1. Реализовать детальную страницу материалов. (с использованием тегированного кэша, работу с get, post, request параметрами организовать стандартными средствами битрикса (Класс Context, Request)), детализация картинки должна быть реализована по умолчанию, но при этом изменить размер картинки должна иметься возможность через параметры компонента. (для списка можно использовать news.list)
1. Реализовать компонент комментарии к записи, при добавлении комментария должен сбрасываться тегированый кеш, если имеется, компонент комментариев должен вызываться в шаблоне детальной страницы.
1. Код должен соответствовать стандартам PSR-2 - http://idealcms.ru/blog/PSR-2-coding-style-guide.html
1. Результат работы залить в гит (НЕ АРХИВОМ), должно быть как минимум две ветки и они должны быть влиты в мастер

## Решение

### Детальная страница материалов

* Реализован компонент dom.detail в пространстве dom.r
* Создано описание компонента .description.php (при добавлении компонента через битрикс этот компонент будет находится в разделе "Дом РФ"")
* Компонент принимает следующие параметры:
    * Шаблон компонента
    * Имя get-параметра в котором передается id элемента
    * Тип кеширования
    * Время кеширования (сек.)
    * Высота картинки
    * Ширина картинки
* Компонент работает с языковыми файлами и готов к расширению локализации
* Компонент реализван через класс
* Компонент обрезает детальное изображение (по умолчанию 50*50) используя алгоритм BX_RESIZE_IMAGE_PROPORTIONAL
* Компонент использует встроенное тегированное кеширование
* При отсутствии нужного элемента, пользователю отдается 404 с переадресацией на карту сайта 