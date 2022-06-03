/**
 * パスワードのフォーマットを確認
 * @param {string=} passwordVal パスワード
 * @returns {boolean} フォーマットが正しい場合はtrueを返す
 */
function validatePassword(passwordVal) {
    // 半角英小文字、大文字、数字を含む9文字以上32文字以内であればtrueを返す
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])[a-zA-Z0-9]{9,32}$/.test(passwordVal);
}

/**
 * メールアドレスのフォーマットを確認
 * @param {string=} emailVal メールアドレス
 * @returns {boolean} フォーマットが正しい場合はtrueを返す
 */
function validateEmail(emailVal) {
    // メールアドレス形式の場合trueを返す
    
    return /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_-]{1,}\.[A-Za-z0-9]{1,}\.{0,1}[A-Za-z0-9]{1,}$/.test(emailVal);
}

/**
 * URLのフォーマットを確認
 * @param {string=} urlVal URL
 * @returns {boolean} フォーマットが正しい場合はtrueを返す
 */
function validateUrl(urlVal) {
    // URL形式の場合trueを返す
    return /^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/.test(urlVal);
}

/**
 * 年のフォーマットを確認
 * @param {number=} year 年
 * @returns {boolean} フォーマットが正しい場合はtrueを返す
 */
function validateYear(year) {
    // 年が2022年以降2100年以下である場合はtrueを返す
    if (year >= 2022 && year <= 2100) {
        yearValidate = true;
    } else {
        yearValidate = false;
    }
    return yearValidate;
}

/**
 * 月のフォーマットを確認
 * @param {number=} month 月
 * @returns {boolean} フォーマットが正しい場合はtrueを返す
 */
function validateMonth(month) {
    // 月が1月以降12月以下である場合はtrueを返す
    if (month >= 1 && month <= 12) {
        monthValidate = true;
    } else {
        monthValidate = false;
    }
    return monthValidate;
}

/**
 * 日付のフォーマットを確認
 * @param {number=} day 日付
 * @returns {boolean} フォーマットが正しい場合はtrueを返す
 */
function validateDay(day) {
    // 日付が1日以降31日以下である場合はtrueを返す
    if (day >= 1 && day <= 31) {
        dayValidate = true;
    } else {
        dayValidate = false;
    }
    return dayValidate;
}
