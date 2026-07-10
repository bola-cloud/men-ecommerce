# سجل التعديلات المخصصة لمشروع 6Valley (Men E-commerce)

تم إنشاء هذا الملف لتوثيق كافة التعديلات البرمجية التي تمت على الكود الأساسي للمشروع، بحيث يمكنك الرجوع إليها، مراجعتها، أو التراجع عنها مستقبلاً إذا دعت الحاجة.

---

## 1. حل مشكلة (Array offset) في ألوان النظام
**وصف المشكلة:** كان النظام يظهر رسالة خطأ (500 Server Error) عند محاولة الوصول لألوان النظام من قاعدة البيانات إذا لم تكن البيانات مسجلة بصيغة مصفوفة (Array) صحيحة.
**الملف المعدل:** 
`app/Providers/AppServiceProvider.php`
**التفاصيل:**
قمنا بإضافة شرط للتأكد من أن القيمة المسترجعة هي مصفوفة قبل استخدامها.
- **التعديل الذي تم:**
```php
$systemColors = getWebConfig(name: 'colors');
// التعديل: التأكد من أن القيمة مصفوفة لتفادي الخطأ
$systemColors = is_array($systemColors) ? $systemColors : [];
```

---

## 2. إخفاء نظام "مندوبي التوصيل" (Delivery Men) من لوحة التحكم
**وصف المشكلة:** الرغبة في إخفاء أيقونات وقوائم إدارة مندوبي التوصيل من لوحة تحكم الإدارة لتبسيط الواجهة. تم التعديل في ملفين لإخفائه من القائمة الجانبية ومن إعدادات النظام.

### أ- الإخفاء من قائمة إعدادات النظام (Business Setup)
**الملف المعدل:**
`resources/views/admin-views/business-settings/business-setup-inline-menu.blade.php`
**التفاصيل:**
تم عمل تعليق (Comment) برمجي `{{-- ... --}}` للكود الخاص بتبويب "Delivery Men".
- **التعديل الذي تم (تم تهميش الكود التالي):**
```html
{{-- <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/business-settings/delivery-man-settings') ? 'active' : '' }}"
        href="{{ route('admin.business-settings.delivery-man-settings') }}">
        {{ translate('Delivery_Men') }}
    </a>
</li> --}}
```

### ب- الإخفاء من القائمة الجانبية الرئيسية (Admin Sidebar)
**الملف المعدل:**
`resources/views/layouts/admin/partials/_side-bar.blade.php`
**التفاصيل:**
تم عمل تعليق برمجي `{{-- ... --}}` لكامل العنصر `<li>` الخاص بـ `admin/delivery-man*` والذي كان يمتد من السطر 901 تقريباً إلى السطر 944.
- **التعديل الذي تم (تهميش قسم مندوبي التوصيل):**
```html
{{-- <li class="{{ Request::is('admin/delivery-man*') ? 'sub-menu-opened' : '' }}">
    <a class="nav-link nav-link-toggle text-capitalize {{ Request::is('admin/delivery-man*') ? 'active' : '' }}" ...>
    ...
    </ul>
</li> --}}
```

---

## 3. برمجة كود إضافة منتجات وهمية للرجال (Seeder)
**وصف المشكلة:** الرغبة في إضافة ماركات وأقسام ومنتجات تجريبية (Men Fashion) تحتوي على صور يتم تحميلها تلقائياً من الإنترنت أثناء عمل Seed، نظراً لأن نظام 6Valley يتطلب أن تكون الصور مخزنة محلياً.
**الملفات المضافة/المعدلة:**
1. إنشاء ملف: `database/seeders/MenFashionSeeder.php`
**(ملاحظة: تم نقل الملف من `database/seeds` إلى `database/seeders` لكي يتوافق مع إعدادات Composer في Laravel 8+ ولتجنب خطأ Target class does not exist).**

**التفاصيل:**
يحتوي الملف على كود يقوم بـ:
- تحميل صور من موقع Unsplash بصيغة آمنة وحفظها في مجلد `storage/app/public/` (للفئات، الماركات، والمنتجات).
- إضافة فئة باسم "Men Shirts".
- إضافة ماركة باسم "Zara Men".
- إضافة منتج متكامل "Classic Men Shirt" وربطه بالفئة والماركة ووضع السعر والمخزون، وتعيينه كمنتج للإدارة (In-House).

---

## 4. إخفاء نظام "مندوبي التوصيل" (Delivery Men) من باقي واجهات النظام
**وصف المشكلة:** استكمالاً لعملية تبسيط واجهات النظام وإزالة نظام التوصيل، تم إخفاء أيقونات وقوائم إدارة مندوبي التوصيل من لوحة تحكم البائعين (Vendors) ومن واجهات تفاصيل الطلبات والمحادثات لكلا من الإدارة والبائعين.

**الملفات المعدلة:**
- `resources/views/admin-views/system/partials/_users.blade.php`: إخفاء ويدجيت "Top Delivery Man" من لوحة تحكم الإدارة.
- `resources/views/vendor-views/dashboard/index.blade.php` و `resources/views/vendor-views/partials/_top-rated-delivery-man.blade.php`: إخفاء ويدجيت "Top Rated Delivery Man" من لوحة تحكم البائع.
- `resources/views/admin-views/order/order-details.blade.php`: إخفاء قائمة تعيين مندوب توصيل (Assign delivery man) في تفاصيل طلب الإدارة.
- `resources/views/vendor-views/order/order-details.blade.php`: إخفاء قائمة تعيين مندوب توصيل (Assign delivery man) في تفاصيل طلب البائع.
- `resources/views/admin-views/chatting/index.blade.php`: إخفاء تبويب "Delivery Men" من واجهة المحادثات للإدارة.
- `resources/views/vendor-views/chatting/index.blade.php`: إخفاء تبويب "Delivery Men" من واجهة المحادثات للبائعين.
- `resources/views/layouts/vendor/partials/_side-bar.blade.php`: إخفاء قائمة "Delivery Man" من القائمة الجانبية للبائع (v1).
- `resources/views/layouts/vendor/partials/v2/_side-bar.blade.php`: إخفاء قائمة "Delivery Man" من القائمة الجانبية للبائع (v2).
- `resources/views/layouts/vendor/partials/v2/_header.blade.php`: إخفاء قائمة محادثات "Delivery Man" من رأس الصفحة للبائع (v2).

**التفاصيل:**
تم استخدام التعليقات البرمجية `{{-- ... --}}` لتهميش الأكواد المسؤولة عن عرض هذه الواجهات لتجنب حذفها نهائياً مما يسمح باستعادتها في المستقبل في حال الحاجة لذلك.

---

## 5. تبسيط القائمة الجانبية للإدارة (Admin Sidebar V2 & V1)
**وصف المشكلة:** الرغبة في إخفاء بعض الأقسام من القائمة الجانبية للإدارة لتبسيط لوحة التحكم وعدم إظهار بعض الإعدادات المتقدمة (مثل إعدادات النظام وتطبيقات الطرف الثالث) أو أقسام لا يتم استخدامها (مثل المنتجات، التسويق، المستخدمين، والتقارير).

**تم إخفاء الأقسام التالية عبر التعليق البرمجي `{{-- --}}`:**
- **System Settings** (إعدادات النظام)
- **3rd Party Setup** (إعدادات الطرف الثالث)
- **Themes & Addons** (القوالب والإضافات)
- **Catalog** (المنتجات/الكتالوج)
- **Marketing** (التسويق)
- **People** (المستخدمين)
- **Reports** (التقارير)

**الملفات المعدلة:**
1. `resources/views/layouts/admin/partials/_side-bar.blade.php`: إخفاء إعدادات النظام والطرف الثالث والقوالب من القائمة الجانبية القديمة (V1).
2. `resources/views/layouts/admin/partials/v2/_side-bar.blade.php`: إخفاء جميع الأقسام المذكورة أعلاه من القائمة الجانبية الجديدة (V2).
3. `resources/views/layouts/admin/partials/v2/_rail.blade.php`: إخفاء الأيقونات المصغرة للأقسام الأربعة المذكورة (الكتالوج، التسويق، الأشخاص، التقارير) من القائمة الجانبية الجانبية (Slim sidebar) لتصميم V2.

**ملاحظة:** لإعادة إظهار أي قسم، يمكنك الدخول للملفات المذكورة ومسح التعليق البرمجي حول القسم المطلوب.

---

## 6. إخفاء تبويبات الشحن ومناطق التوصيل من إعدادات النظام
**وصف المشكلة:** إخفاء تبويبات (Shipping Method) و (Delivery Zone) من القائمة الأفقية العلوية (Tabs) في واجهة (Business Setup) لإلغاء هذه الصلاحيات من الظهور للإدارة.

**الملف المعدل:**
`resources/views/admin-views/business-settings/business-setup-inline-menu.blade.php`

**التفاصيل:**
تم عمل تعليق برمجي `{{-- --}}` حول أزرار `Shipping_Method` و `Delivery_Zone` لتختفي من القائمة الأفقية.

---

## 📝 ملاحظات هامة لك مستقبلاً:
1. **لاسترجاع الدليفري (Delivery Men):** كل ما عليك هو فتح ملفات الـ `blade` المذكورة أعلاه، وإزالة علامات التعليق `{{--` و `--}}` ليعود كل شيء للظهور في لوحة التحكم.
2. **عند رفع الكود للسيرفر أو إضافة كلاسات جديدة:** تذكر دائماً تنفيذ أمر `composer dump-autoload` ليقوم السيرفر بقراءة مسارات الكلاسات الجديدة مثل `MenFashionSeeder`.
3. **بعد أي تعديل على ملفات الـ Views (.blade.php):** إذا لم تظهر التعديلات، قم بتنفيذ الأمر `php artisan cache:clear` وكذلك `php artisan view:clear`.
