// 通常新規登録ページ(sign_up.html)
// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // メールアドレスのフォーカスが外れた際にcheckInput実行
    jQuery('#email').on('blur', function() {
        checkInput();
    });
    // 会員規約がクリックされた際にcheckInput実行
    jQuery('#terms').on('click', function() {
        checkInput();
    });
    // 仮登録ボタンを押された際に、メール送信済みメッセージを表示
    // jQuery('#register-btn').on('click', function() {
    //   showEmailSentMsg();
    //});
});

// 入力項目を確認し、仮登録ボタン有効化/無効化切り替え
function checkInput() {
    // メールアドレスが入力された場合、emailCheckにtrueを格納
    var emailCheck = false;
    // メールアドレスの入力フォーム要素を取得
    var email = document.getElementById('email');
    // 会員規約のチェックボックス要素を取得
    var terms = document.getElementById('terms');
    // 仮登録のボタン要素を取得
    var registerBtn = document.getElementById('register-btn');

    // メールアドレスに空白文字が含まれていないかを確認
    if (!email.value.match(/[\x20\u3000]/)) {
        // メールアドレスのフォーマットを確認
        emailCheck = validateEmail(email.value);
    }

    // メールアドレスが入力されている、かつ会員規約にチェックがついている場合ボタンを有効化
    registerBtn.disabled = true;
    if (emailCheck === true && terms.checked === true) {
        registerBtn.disabled = false;
    }
}

/**
 * パスワードリセットページ
 */
// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // メールアドレスのフォーカスが外れた際にcheckPwResetInput実行
    jQuery('#pwResetEmail').on('blur', function() {
        checkPwResetInput();
    });
});

// 入力項目を確認し、パスワード再発行ボタンを有効化/無効化切り替え
function checkPwResetInput() {
    // パスワード再発行ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    var pwResetEmail = false;

    // メールアドレスの値取得
    var pwResetEmailVal = jQuery('#pwResetEmail').val();

    // メールアドレスが入力されているかを確認
    if (pwResetEmailVal.length > 0) {
        // メールアドレスが入力されている場合、エラーメッセージを非表示
        jQuery('#emailErrMsg').hide();
        // メールアドレスに空白文字が含まれていないかを確認
        if (!pwResetEmailVal.match(/[\x20\u3000]/)) {
            // メールアドレスのフォーマットを確認
            pwResetEmail = validateEmail(pwResetEmailVal);
        }
    } else {
        // メールアドレスが入力されていない場合、エラーメッセージを表示
        showTypeEmailMsg();
    }

    // 入力項目の値が正しい場合、パスワード再発行ボタンを有効化
    if (pwResetEmail === true) {
        disabledFlag = false;
    }
    jQuery('#resetpw-btn').attr('disabled', disabledFlag);
}

// メールアドレスが入力されていない場合、メッセージを表示
function showTypeEmailMsg() {
    jQuery('#inputEmailMsg').empty().append("<p id=\"emailErrMsg\">メールアドレスを入力してください</p>");
}

/**
 * ログインページ(login.html)
 */
// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // メールアドレスのフォーカスが外れた際にcheckLoginInput実行
    jQuery('#loginEmail').on('blur', function() {
        checkLoginInput();
    });
    // パスワードのフォーカスが外れた際にcheckLoginInput実行
    jQuery('#loginPassword').on('blur', function() {
        checkLoginInput();
    });
});

// 入力項目を確認し、ログインボタン有効化/無効化切り替え
function checkLoginInput() {
    // ログインボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    var loginEmail = false;
    var loginPassword = false;

    // メールアドレスの値取得
    var emailVal = jQuery('#loginEmail').val();
    // パスワードの値取得
    var passwordVal = jQuery('#loginPassword').val();

    // メールアドレスが入力されているかを確認
    if (emailVal.length > 0) {
        // メールアドレスに空白文字が含まれていないかを確認
        if (!emailVal.match(/[\x20\u3000]/)) {
            // メールアドレスのフォーマットを確認
            loginEmail = validateEmail(emailVal);
        }
    }
    // パスワードが入力されているかを確認
    if (passwordVal.length > 0) {
        // パスワードに空白文字が含まれていないかを確認
        if (!passwordVal.match(/[\x20\u3000/]/)) {
            // パスワードのフォーマットを確認
            loginPassword = validatePassword(passwordVal);
        }
    }

    // 入力項目の値が正しい場合、ログインボタンを有効化
    if (loginEmail === true && loginPassword === true) {
        disabledFlag = false;
    }
    jQuery('#login-btn').attr('disabled', disabledFlag);
}

// 画像サイズの検証
function validateImageSize(file, fileInput) {
    const sizeLimit = 1024 * 1024 * 100;
    if (file.size > sizeLimit) {
        alert('ファイルのサイズは100MB以下にしてください');
        fileInput.value = '';
        exit();
    }
}

// 選択した画像に置き換える
function replaceImage(file, image) {
    let fr = new FileReader();
    fr.readAsDataURL(file);
    fr.onload = function() {
        image.setAttribute('src', fr.result);
    }
}

// メール送信済みメッセージを表示
function showEmailSentMsg() {
    jQuery('#emailSentMsg').append("<p>下記のメールアドレスに仮登録メールを送信いたしました。</p>");
}

/**
 * 本登録ページ(register.html)
 */
// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // ユーザーネームのフォーカスが外れた際にcheckRegisterInput実行
    jQuery('#username').on('blur', function() {
        checkRegisterInput();
    });
    // 名前のフォーカスが外れた際にcheckRegisterInput実行
    jQuery('#name').on('blur', function() {
        checkRegisterInput();
    });
    // パスワードのフォーカスが外れた際にcheckRegisterInput実行
    jQuery('#password').on('blur', function() {
        checkRegisterInput();
    });
    // パスワードを再入力のフォーカスが外れた際にcheckRegisterInput実行
    jQuery('#password_confirmation').on('blur', function() {
        checkRegisterInput();
    });
});

// 入力項目を確認し、新規登録ボタン有効化/無効化切り替え
function checkRegisterInput() {
    // 新規登録ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    var usernameFlag = false;
    var nameFlg = false;
    var passwordFlg = false;
    var pwConfirmFlg = false;

    // ユーザーネームの値取得
    var usernameVal = jQuery('#username').val();
    // 名前の値取得
    var nameVal = jQuery('#name').val();
    // パスワードの値取得
    var passwordVal = jQuery('#password').val();
    // パスワードを再入力の値取得
    var pwConfirmVal = jQuery('#password_confirmation').val();

    // ユーザーネームが入力されているかを確認
    if (usernameVal.length > 0) {
        // ユーザーネームに空白文字が含まれていないかを確認
        if (!usernameVal.match(/[\x20\u3000]/)) {
            usernameFlag = true;
        }
    }

    // 名前が入力されているかを確認
    if (nameVal.length > 0) {
        // 名前に空白文字が含まれていないかを確認
        if (!nameVal.match(/[\x20\u3000]/)) {
            nameFlg = true;
        }
    }

    // パスワードが入力されているかを確認
    if (passwordVal.length > 0) {
        // パスワードが入力されている場合、エラーメッセージを非表示
        jQuery('#inputPwErrMsg').hide();
        // パスワードに空白文字が含まれていないかを確認
        if (!passwordVal.match(/[\x20\u3000]/)) {
            // パスワードのフォーマットを確認
            var passwordFlg = validatePassword(passwordVal);
            if (passwordFlg === false) {
                // パスワードのフォーマットが正しくない場合、エラーメッセージを表示
                showPwValidateMsg();
            }
        } else {
            showPwValidateMsg2();
        }
    }

    // パスワードを再入力が入力されているかを確認
    if (pwConfirmVal.length > 0) {
        // パスワードを再入力が入力されている場合、エラーメッセージを非表示
        jQuery('#inputPwConfirmErrMsg').hide();
        // パスワードとパスワードを再入力の値が同じかを確認
        if (passwordVal === pwConfirmVal) {
            pwConfirmFlg = true;
        } else {
            // パスワードが合っていない場合、エラーメッセージを表示
            showPwNotMatchMsg();
        }
    }

    // 入力項目の値が正しい場合、新規登録ボタンを有効化
    if (usernameFlag === true && nameFlg === true && passwordFlg === true && pwConfirmFlg === true) {
        disabledFlag = false;
    }
    jQuery('#register-btn').attr('disabled', disabledFlag);
}

/**
 * パスワードリセットページ(pass_reset.html)
 */
// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // パスワードのフォーカスが外れた際にcheckSetPwInput実行
    jQuery('#newPw').on('blur', function() {
        checkSetPwInput();
        showTypePwMsg();
    });
    // 新しいパスワードを再入力のフォーカスが外れた際にcheckSetPwInput実行
    jQuery('#newPwConfirm').on('blur', function() {
        checkSetPwInput();
        showTypePwConfirmMsg();
    });
});

// 入力項目を確認し、新規登録ボタン有効化/無効化切り替え
function checkSetPwInput() {
    // 新規登録ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    var flagNewPw = false;
    var flagNewPwConfirm = false;

    // パスワードの値取得
    var newPwVal = jQuery('#newPw').val();
    // パスワードを再入力の値取得
    var newPwConfirmVal = jQuery('#newPwConfirm').val();

    // パスワードが入力されているかを確認
    if (newPwVal.length > 0) {
        // パスワードが入力されている場合、エラーメッセージを非表示
        jQuery('#inputPwErrMsg').hide();
        // パスワードに空白文字が含まれていないかを確認
        if (!newPwVal.match(/[\x20\u3000]/)) {
            // パスワードのフォーマットを確認
            var flagNewPw = validatePassword(newPwVal);
            if (flagNewPw === false) {
                // パスワードのフォーマットが正しくない場合、エラーメッセージを表示
                showPwValidateMsg();
            }
        }
    }

    // パスワードを再入力が入力されているかを確認
    if (newPwConfirmVal.length > 0) {
        // パスワードを再入力が入力されている場合、エラーメッセージを非表示
        jQuery('#inputPwConfirmErrMsg').hide();
        // パスワードとパスワードを再入力の値が同じかを確認
        if (newPwVal === newPwConfirmVal) {
            flagNewPwConfirm = true;
        } else {
            // パスワードが合っていない場合、エラーメッセージを表示
            showPwNotMatchMsg();
        }
    }

    // 入力項目の値が正しい場合、新規登録ボタンを有効化
    if (flagNewPw === true && flagNewPwConfirm === true) {
        disabledFlag = false;
    }
    jQuery('#setpw-btn').attr('disabled', disabledFlag);
}

// パスワードが入力されていない場合、メッセージを表示
function showTypePwMsg() {
    // パスワードの値取得
    var newPwLength = jQuery('#newPw').val().length;
    if (newPwLength <= 0) {
        jQuery('#inputPwMsg').empty().append("<p id=\"inputPwErrMsg\" class=\"pwResetErrMsg\">パスワードを入力してください</p>");
    }
}

// パスワードを再入力が入力されていない場合、メッセージを表示
function showTypePwConfirmMsg() {
    // パスワードを再入力の値取得
    var newPwConfirmLength = jQuery('#newPwConfirm').val().length;
    if (newPwConfirmLength <= 0) {
        jQuery('#inputPwConfirmMsg').empty().append("<p id=\"inputPwConfirmErrMsg\" class=\"pwResetErrMsg\">パスワードを入力してください</p>");
    }
}

// パスワードのフォーマットが正しくない場合、メッセージを表示
function showPwValidateMsg() {
    jQuery('#inputPwMsg').empty().append("<p id=\"inputPwErrMsg\" class=\"pwResetErrMsg\">パスワードは半角英小文字、大文字、数字を含む9文字以上32文字以内を入力してください</p>");
}

// パスワードに空欄がある場合、メッセージを表示
function showPwValidateMsg2() {
    jQuery('#inputPwMsg').empty().append("<p id=\"inputPwErrMsg\" class=\"pwResetErrMsg\">パスワードにスペースは含めないでください</p>");
}

// パスワードが合っていない場合、メッセージを表示
function showPwNotMatchMsg() {
    jQuery('#inputPwConfirmMsg').empty().append("<p id=\"inputPwConfirmErrMsg\" class=\"pwResetErrMsg\">パスワードが一致しません</p>");
}

// 検索オプションのモーダル開閉
jQuery(function($) {
    var open = jQuery('.modal-open'),
        container = jQuery('.modal-container');

    //開くボタンをクリックしたらモーダルを表示する
    open.on('click', function() {
        container.addClass('active');
        return false;
    });

    //モーダルの外側をクリックしたらモーダルを閉じる
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.modal-body').length) {
            container.removeClass('active');
        }
    });
});

// タブの選択機能（post_search.html,request_searched_list.html）
jQuery(function($) {

    jQuery('#front_search_box').on('blur', function() {
        var search_txt = jQuery('#front_search_box').val();
        jQuery('#modal_search_box').val(search_txt);
    });

    jQuery('#desc').click(function() {
        selectTab($(this));
    });

    jQuery('#asc').click(function() {
        selectTab($(this));
    });

    jQuery('#low').click(function() {
        selectTab($(this));
    });

    jQuery('#high').click(function() {
        selectTab($(this));
    });

});

// キープ済み、キープの選択機能（request_searched_list.html,request_received_list_html）
/**
jQuery(function($) {
    var $ = jQuery.noConflict();

    $(document).on('click', '.keep_off', function() {
        let keep_on = jQuery('<div class="rounded-pill text-center mb-1 px-1 keep_on"><img src="assets/img/icon/keep_on.png" alt="keep-on" class="keep-on"></div>');
        $(this).replaceWith(keep_on);
    });

    $(document).on('click', '.keep_on', function() {
        let keep_off = jQuery('<div class="border rounded-pill text-center mb-1 px-1 keep_off"><img src="assets/img/icon/keep_off.png" alt="keep-off" class="keep-off"></div>');
        $(this).replaceWith(keep_off);
    });
});
 */

/**
 * 作品依頼（通常依頼）提案ページ
 */
// ファイルが選択された際、ファイル名を表示
jQuery('#requestFile').on('change', function() {
    var $ = jQuery.noConflict();

    // 添付されたファイルを取得
    var selectedFile = $(this).prop('files')[0];
    // ファイルが存在している場合
    if (selectedFile) {
        // 選択されたファイルが10文字以上ある場合、10文字以下を「...」で省略
        var selectedFileName = selectedFile.name.length > 10 ? (selectedFile.name).slice(0, 10) + "..." : selectedFile.name;
        // ファイル名を表示
        jQuery('#outputFileName').text(selectedFileName);
        // バリデーション文言を非表示
        jQuery('#inputRequestErrMsgArea').addClass('d-none');
    } else {
        // 添付ファイルを空に変更
        this.value = '';
        // ファイル名を空に変更
        jQuery('#outputFileName').text('');
        // バリデーション文言を表示
        jQuery('#inputRequestErrMsgArea').removeClass('d-none');
    }
    // 必須項目のチェック
    checkRequestInput();
});
/**
 * 作品依頼（通常依頼）提案ページ
 */
// ファイル選択ボタンがクリックされた際、バリデーション文言を表示
jQuery('#requestFile').on('click', function() {
    // ファイルが存在しない場合、バリデーション文言を表示
    if (this.files.length === 0) {
        jQuery('#inputRequestErrMsgArea').removeClass('d-none');
    };
    // 必須項目のチェック
    checkRequestInput();
});

// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // 依頼タイトルのフォーカスが外れた際にcheckRequestInput実行
    jQuery('#requestTitle').on('blur', function() {
        checkRequestInput();
        typeRequestTitleMsg();
    });
    // 作品タイトルのフォーカスが外れた際にcheckRequestInput実行
    jQuery('#workTitle').on('blur', function() {
        checkRequestInput();
        typeWorkTitleMsg();
    });
    // 本文のフォーカスが外れた際にcheckRequestInput実行
    jQuery('#text').on('blur', function() {
        checkRequestInput();
        typeTextMsg();
    });
    // 構図のフォーカスが外れた際にcheckRequestInput実行
    jQuery('#composition').on('blur', function() {
        checkRequestInput();
        typeCompositionMsg();
    });
    // キャラクターのフォーカスが外れた際にcheckRequestInput実行
    jQuery('#character').on('blur', function() {
        checkRequestInput();
        typeCharacterMsg();
    });
    // 参考URLのフォーカスが外れた際にcheckRequestInput実行
    jQuery('#refUrl').on('blur', function() {
        checkRequestInput();
        typeRefUrlMsg();
    });
    // 予算のフォーカスが外れた際にcheckRequestInput実行
    jQuery('#budget').on('blur', function() {
        checkRequestInput();
        typeBudgetMsg();
    });
    // 応募期限（年）のフォーカスが外れた際にcheckRequestInput実行
    jQuery('#appDeadlineY').on('blur', function() {
        checkRequestInput();
        typeAppDeadlineMsg();
    });
    // 応募期限（月）のフォーカスが外れた際にcheckRequestInput実行
    jQuery('#appDeadlineM').on('blur', function() {
        checkRequestInput();
        typeAppDeadlineMsg();
    });
    // 応募期限（日）のフォーカスが外れた際にcheckRequestInput実行
    jQuery('#appDeadlineD').on('blur', function() {
        checkRequestInput();
        typeAppDeadlineMsg();
    });
});

// 入力項目を確認し、依頼投稿確認ボタン有効化/無効化切り替え
function checkRequestInput() {
    // 新規登録ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    var flagRequestTitle = false;
    var flagWorkTitle = false;
    var flagText = false;
    var flagComposition = false;
    var flagCharacter = false;
    var flagRequestFile = false;
    var flagRefUrl = false;
    var flagBudget = false;
    var flagAppDeadline = false;

    // 依頼タイトルの値取得
    var requestTitleVal = jQuery('#requestTitle').val();
    // 作品タイトルの値取得
    var workTitleVal = jQuery('#workTitle').val();
    // 本文の値取得
    var textVal = jQuery('#text').val();
    // 構図の値取得
    var compositionVal = jQuery('#composition').val();
    // キャラクターの値取得
    var characterVal = jQuery('#character').val();
    // 添付ファイルの値取得
    var requestFileVal = jQuery('#requestFile').val();
    // 参考URLの値取得
    var refUrlVal = jQuery('#refUrl').val();
    // 予算の値取得
    var budgetVal = jQuery('#budget').val();
    // 応募期限（年）の値取得
    var appDeadlineYVal = jQuery('#appDeadlineY').val();
    // 応募期限（月）の値取得
    var appDeadlineMVal = jQuery('#appDeadlineM').val();
    // 応募期限（日）の値取得
    var appDeadlineDVal = jQuery('#appDeadlineD').val();

    // 依頼タイトルが入力されているかを確認
    if (requestTitleVal.length > 0) {
        // 依頼タイトルが入力されている場合、エラーメッセージを非表示
        jQuery('#inputRequestErrMsg').hide();
        // 依頼タイトルに空白文字が含まれていないかを確認
        if (!requestTitleVal.match(/[\x20\u3000]/)) {
            flagRequestTitle = true;
        }
    }

    // 作品タイトルが入力されているかを確認
    if (workTitleVal.length > 0) {
        // 作品タイトルが入力されている場合、エラーメッセージを非表示
        jQuery('#inputWorkErrMsg').hide();
        // 作品タイトルに空白文字が含まれていないかを確認
        if (!workTitleVal.match(/[\x20\u3000]/)) {
            flagWorkTitle = true;
        }
    }

    // 本文が入力されているかを確認
    if (textVal.length > 0) {
        // 本文が入力されている場合、エラーメッセージを非表示
        jQuery('#inputTextErrMsg').hide();
        // 本文に空白文字が含まれていないかを確認
        if (!textVal.match(/[\x20\u3000]/)) {
            flagText = true;
        }
    }

    // 構図が入力されているかを確認
    if (compositionVal.length > 0) {
        // 構図が入力されている場合、エラーメッセージを非表示
        jQuery('#inputCompositionErrMsg').hide();
        // 構図に空白文字が含まれていないかを確認
        if (!compositionVal.match(/[\x20\u3000]/)) {
            flagComposition = true;
        }
    }

    // キャラクターが入力されているかを確認
    if (characterVal.length > 0) {
        // キャラクターが入力されている場合、エラーメッセージを非表示
        jQuery('#inputCharacterErrMsg').hide();
        // キャラクターに空白文字が含まれていないかを確認
        if (!characterVal.match(/[\x20\u3000]/)) {
            flagCharacter = true;
        }
    }

    // 添付ファイルが入力されているかを確認
    if (requestFileVal) {
        // 添付ファイルが入力されている場合、エラーメッセージを非表示
        flagRequestFile = true;
        jQuery('#inputRequestErrMsgArea').addClass('d-none');
    }

    // 参考URLが入力されているかを確認
    if (refUrlVal.length > 0) {
        // 参考URLに空白文字が含まれていないかを確認
        if (!refUrlVal.match(/[\x20\u3000]/)) {
            // 参考URLの形式を確認
            flagRefUrl = validateUrl(refUrlVal);
            if (flagRefUrl === true) {
                // 参考URLが入力されている場合、エラーメッセージを非表示
                jQuery('#validRefUrlErrMsg').hide();
            }
        }
    } else {
        // 参考URLに何も入力されていない場合、URLのフラグはtrue
        flagRefUrl = true;
    }

    // 予算が入力されているかを確認
    if (budgetVal.length > 0) {
        // 予算が入力されている場合、エラーメッセージを非表示
        jQuery('#inputBudgetErrMsg').hide();
        // 予算に空白文字が含まれていないかを確認
        if (!budgetVal.match(/[\x20\u3000]/)) {
            flagBudget = true;
        }
    }

    // 応募期限（年）が入力されている場合
    if (appDeadlineYVal.length > 0) {
        // 年のフォーマットを確認
        yearValidated = validateYear(appDeadlineYVal);
        if (yearValidated === true) {
            // 年のフォーマットが正しい場合、エラーメッセージを非表示
            jQuery('#dateFormatYErrMsg').hide();
            // 応募期限（月）が入力されている場合
            if (appDeadlineMVal.length > 0) {
                // 月のフォーマットを確認
                monthValidated = validateMonth(appDeadlineMVal);
                if (monthValidated === true) {
                    // 月のフォーマットが正しい場合、エラーメッセージを非表示
                    jQuery('#dateFormatMErrMsg').hide();
                    // 応募期限（日）が入力されている場合
                    if (appDeadlineDVal.length > 0) {
                        // 日のフォーマットを確認
                        dayValidated = validateDay(appDeadlineDVal);
                        if (dayValidated === true) {
                            // 日のフォーマットが正しい場合、エラーメッセージを非表示
                            jQuery('#dateFormatDErrMsg').hide();
                            // 応募期限フラグをtrueに設定
                            flagAppDeadline = true;
                            // 年月日が設定されている場合、エラーメッセージを非表示
                            jQuery('#inputAppDeadlineMsg').hide();
                        } else {
                            dateFormatDInvalidMsg();
                        }
                    }
                } else {
                    dateFormatMInvalidMsg();
                }
            }
        } else {
            dateFormatYInvalidMsg();
        }
    }

    // 入力項目の値が正しい場合、新規登録ボタンを有効化
    if (flagRequestTitle === true && flagWorkTitle === true && flagText === true && flagComposition === true && flagCharacter === true && flagRefUrl === true && flagBudget === true && flagAppDeadline === true && flagRequestFile === true) {
        disabledFlag = false;
    }
    jQuery('#requestBtn').attr('disabled', disabledFlag);
}

// 依頼タイトルが入力されていない場合、メッセージを表示
function typeRequestTitleMsg() {
    // 依頼タイトルの値取得
    var requestTitleLength = jQuery('#requestTitle').val().length;
    if (requestTitleLength <= 0) {
        jQuery('#inputRequestTitle').empty().append("<p id=\"inputRequestErrMsg\" class=\"inputRequestErrMsg\">依頼タイトルを入力してください</p>");
    }
}
// 作品タイトルが入力されていない場合、メッセージを表示
function typeWorkTitleMsg() {
    // 作品タイトルの値取得
    var workTitleLength = jQuery('#workTitle').val().length;
    if (workTitleLength <= 0) {
        jQuery('#inputWorkTitle').empty().append("<p id=\"inputWorkErrMsg\" class=\"inputRequestErrMsg mt-1\">作品タイトルを入力してください</p>");
    }
}
// 本文が入力されていない場合、メッセージを表示
function typeTextMsg() {
    // 本文の値取得
    var textLength = jQuery('#text').val().length;
    if (textLength <= 0) {
        jQuery('#inputText').empty().append("<p id=\"inputTextErrMsg\" class=\"inputRequestErrMsg mt-1\">本文タイトルを入力してください</p>");
    }
}
// 構図が入力されていない場合、メッセージを表示
function typeCompositionMsg() {
    // 構図の値取得
    var compositionLength = jQuery('#composition').val().length;
    if (compositionLength <= 0) {
        jQuery('#inputComposition').empty().append("<p id=\"inputCompositionErrMsg\" class=\"inputRequestErrMsg mt-1\">構図を入力してください</p>");
    }
}
// キャラクターが入力されていない場合、メッセージを表示
function typeCharacterMsg() {
    // キャラクターの値取得
    var characterLength = jQuery('#character').val().length;
    if (characterLength <= 0) {
        jQuery('#inputCharacter').empty().append("<p id=\"inputCharacterErrMsg\" class=\"inputRequestErrMsg mt-1\">キャラクターを入力してください</p>");
    }
}
// 参考URLの形式が正しくない場合、メッセージを表示
function typeRefUrlMsg() {
    // 参考URLの値を取得
    var refUrlVal = jQuery('#refUrl').val();
    // 参考URLの形式を確認
    refUrlValid = validateUrl(refUrlVal);
    if (refUrlVal.length > 0) {
        if (refUrlValid === false) {
            jQuery('#validRefUrl').empty().append("<p id=\"validRefUrlErrMsg\" class=\"inputRequestErrMsg mt-1\">参考URLの形式が間違っています</p>");
        }
    }
}
// 予算が入力されていない場合、メッセージを表示
function typeBudgetMsg() {
    // 予算の値取得
    var budgetLength = jQuery('#budget').val().length;
    if (budgetLength <= 0) {
        jQuery('#inputBudget').empty().append("<p id=\"inputBudgetErrMsg\" class=\"inputRequestErrMsg mt-1\">予算を入力してください</p>");
    }
}
// 応募期限が入力されていない場合、メッセージを表示
function typeAppDeadlineMsg() {
    // 応募期限（年）の値取得
    var appDeadlineYLength = jQuery('#appDeadlineY').val().length;
    // 応募期限（月）の値取得
    var appDeadlineMLength = jQuery('#appDeadlineM').val().length;
    // 応募期限（日）の値取得
    var appDeadlineDLength = jQuery('#appDeadlineD').val().length;
    // 応募期限の年月日がそれぞれ入力されていない場合、エラーメッセージを表示
    if (appDeadlineYLength <= 0 || appDeadlineMLength <= 0 || appDeadlineDLength <= 0) {
        jQuery('#inputAppDeadline').empty().append("<p id=\"inputAppDeadlineMsg\" class=\"inputRequestErrMsg mt-1\">応募期限を年月日それぞれ入力してください</p>");
    }
}
// 応募期限（年）のフォーマットが正しくない場合、メッセージを表示
function dateFormatYInvalidMsg() {
    jQuery('#inputAppDeadline').empty().append("<p id=\"dateFormatYErrMsg\" class=\"inputRequestErrMsg mt-1\">年のフォーマットが正しくありません</p>");
}
// 応募期限（月）のフォーマットが正しくない場合、メッセージを表示
function dateFormatMInvalidMsg() {
    jQuery('#inputAppDeadline').empty().append("<p id=\"dateFormatMErrMsg\" class=\"inputRequestErrMsg mt-1\">月のフォーマットが正しくありません</p>");
}
// 応募期限（日）のフォーマットが正しくない場合、メッセージを表示
function dateFormatDInvalidMsg() {
    jQuery('#inputAppDeadline').empty().append("<p id=\"dateFormatDErrMsg\" class=\"inputRequestErrMsg mt-1\">日付のフォーマットが正しくありません</p>");
}

// タブの選択表示
function selectTab(target) {
    let sortTabs = jQuery('#sort_tab > button').siblings();
    sortTabs.removeClass('selected-tab');
    sortTabs.addClass('not-selected-tab');
    target.removeClass('not-selected-tab');
    target.addClass('selected-tab');
}
// 画像変更（profile_edit.html）
jQuery(function($) {
    jQuery('#cover_img_file_input').change(function() {
        let file = this.files[0];
        let fileInput = jQuery('#cover_img_file_input').get(0);
        let image = jQuery('#cover_image').get(0);
        validateImageSize(file, fileInput)
        replaceImage(file, image);
    });

    jQuery('#profile_img_file_input').change(function() {
        let file = this.files[0];
        let fileInput = jQuery('#profile_img_file_input').get(0);
        let image = jQuery('#profile_image').get(0);
        validateImageSize(file, fileInput)
        replaceImage(file, image);
    });
});

// 名前・ユーザーネーム入力確認（profile_edit.html）
jQuery(function($) {
    // 名前のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#name_box').on('blur', function() {
        check_ProfileInput();
    });
    // ユーザーネームのフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#user_name_box').on('blur', function() {
        check_ProfileInput();
    });
    // 生年月日のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#calendar_box').on('blur', function() {
        check_ProfileInput();
    });
    // webサイトのフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#url_box').on('blur', function() {
        check_ProfileInput();
    });

});

// 名前・ユーザーネーム入力判定
function check_ProfileInput() {
    jQuery('#NameMsg').hide();
    jQuery('#UserNameMsg').hide();
    jQuery('#CalendarMsg').hide();
    jQuery('#UrlMsg').hide();
    // 保存ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    var name_flg = false;
    var user_name_flg = false;
    var calendar_flg = false;
    var url_flg = false;

    // 名前の値取得
    var nameVal = jQuery('#name_box').val();
    // ユーザーネームの値取得
    var user_nameVal = jQuery('#user_name_box').val();
    // URLの値取得
    var urlVal = jQuery('#url_box').val();
    var calendarVal = jQuery('#calendar_box').val();

    // 名前が入力されているかを確認
    if (nameVal.length > 0) {
        if (!nameVal.match(/^\s+?$/ || /^　+?$/)) {
            name_flg = true;
        } else {
            showNameMsg();
        }
    } else {
        showNameMsg();
    }

    // ユーザーネームが入力されているかを確認
    if (user_nameVal.length > 0) {
        if (!user_nameVal.match(/^\s+?$/ || /^　+?$/)) {
            user_name_flg = true;
        } else {
            showNameMsg();
        }
    } else {
        showUserNameMsg();
    }

    // 生年月日が入力されているかを確認
    if (calendarVal.length > 0) {
        // 生年月日の形式を確認
        if (!calendarVal.match(/^\d{4}\-\d{2}\-\d{2}$/)) {
            // 形式が間違っている場合エラーメッセージ表示
            showCalendarMsg();
        } else {
            calendar_flg = true;
        };
    } else {
        calendar_flg = true;
    };


    // URLが入力されているかを確認
    if (urlVal.length > 0) {
        // URLの空白を確認
        if (!urlVal.match(/[\x20\u3000]/)) {
            // URLのフォーマットを確認
            url_flg = validateUrl(urlVal);
            // URLが間違っている場合エラーメッセージ表示
            if (url_flg === false) {
                showUrlMsg()
            };
            // URLに空欄が入っている場合エラーメッセージ表示
        } else {
            showUrlMsg()
        };
    } else {
        url_flg = true;
    }

    // 正しく入力されている場合、保存ボタンを有効化
    if (name_flg === true && user_name_flg === true && calendar_flg == true && url_flg === true) {
        disabledFlag = false;
    }

    // ボタンの「disabled」の置き換え
    jQuery('#save-btn').attr('disabled', disabledFlag);
}

function showNameMsg() {
    // 名前空欄のメッセージ
    jQuery('#NameMsg').show();
    jQuery('#NameMsg').empty().append("<p id=\"inputNameErrMsg\" class=\"NameErrMsg mb-0\">名前を入力してください</p>");

}

function showUserNameMsg() {
    // ユーザーネーム空欄のメッセージ
    jQuery('#UserNameMsg').show();
    jQuery('#UserNameMsg').empty().append("<p id=\"inputUserNameErrMsg\" class=\"UserNameErrMsg mb-0\">ユーザーネームを入力してください</p>");

}

function showCalendarMsg() {
    // 日付間違っている場合のメッセージ
    jQuery('#CalendarMsg').show();
    jQuery('#CalendarMsg').empty().append("<p id=\"inputCalendarErrMsg\" class=\"CalendarErrMsg mb-0\">生年月日を正しく選択してください</p>");

}

function showUrlMsg() {
    // URL間違っている場合のメッセージ
    jQuery('#UrlMsg').show();
    jQuery('#UrlMsg').empty().append("<p id=\"inputUrlErrMsg\" class=\"UrlErrMsg mb-0\">URLを確認してください</p>");
}

jQuery(function($) {
    jQuery('#chat_button').on('click', function() {
        let inputText = document.getElementById('chat_input');
        let appendArea = document.getElementById('message_show_area');
        outputMessage(inputText, appendArea);
    });
});

// メッセージを画面に出力
function outputMessage(text, area) {
    if (!text.value) return false;
    let time = new Date();
    let hour = ('00' + time.getHours()).slice(-2);
    let min = ('00' + time.getMinutes()).slice(-2);
    let message = $(`<div class="col-12 pb-5 mb-5 pr-0" style="z-index: -1;"><div class="balloon_r"><div class="faceicon"><img src="assets/img/pixta_64747350_M.jpg" class="rounded-circle" alt=""><div class="ml-xl-4 ml-1">${hour + ":" + min }</div></div><div class="says"><p>${text.value}</p></div></div></div>`);
    $(area).append(message);
}

// 画像を画面に出力
function outputImage(imgSrc, area) {
    if (!imgSrc) return false;
    let time = new Date();
    let hour = ('00' + time.getHours()).slice(-2);
    let min = ('00' + time.getMinutes()).slice(-2);
    let image = $(`<div class="col-12 pb-5 mb-5 pr-0" style="z-index: -1;" ><div class="balloon_r"><div class="faceicon"><img src="assets/img/pixta_64747350_M.jpg" class="rounded-circle" alt=""><div class="ml-xl-4 ml-1">${hour + ":" + min }</div></div><img src="${imgSrc}" class="post-image result"></div></div>`);
    $(area).append(image);
}

// メッセージ詳細画面（message_show.html）
jQuery(function($) {
    jQuery('#chat_button').on('click', function() {
        let inputText = document.getElementById('chat_input');
        let appendArea = document.getElementById('message_show_area');
        outputMessage(inputText, appendArea);
        inputText.value = '';
    });

    jQuery('#messages_file_input').change(function() {
        let file = this.files[0];
        let fr = new FileReader();
        fr.readAsDataURL(file);
        fr.onload = function() {
            jQuery('.bigimg').children().attr('src', fr.result).css({
                'width': '40vh',
                'height': '30vh',
                'object-fit': 'cover'
            });
            jQuery('.modal').fadeIn();
            return false;
        }
    });
    jQuery('#post_image_btn').on('click', function() {
        let imgResult = jQuery('.bigimg').children().attr('src')
        let appendArea = document.getElementById('message_show_area');
        outputImage(imgResult, appendArea)
        jQuery('.modal').fadeOut();
    });
});

// フォローする、フォロー中の選択機能
jQuery(function($) {
    var $ = jQuery.noConflict();

    $(document).on('click', '.follow-off', function() {
        let follow_on = jQuery('<button type="button"class="btn btn-primary rounded-pill btn-sm text-white btn-lg main-color follow-btn follow-on">フォロー中</button>');
        $(this).replaceWith(follow_on);
    });

    $(document).on('click', '.follow-on', function() {
        let follow_off = jQuery('<button type="button" class="btn rounded-pill btn-outline-primary btn-sm follow-btn follow-off">フォローする</button>');
        $(this).replaceWith(follow_off);
    });
});

jQuery(function($) {
    // 販売形式のラジオボタン変更で、表示するフォーム切り替え
    jQuery('[name="saleType"]:radio').change(function() {
        // 通常販売にチェックがついている場合
        if (jQuery('#sale').prop('checked')) {
            jQuery('.saleTypeSection').hide();
            jQuery('.saleSection').show();
            jQuery('.termsSection').show();
            // オークションにチェックがついている場合
        } else if (jQuery('#auction').prop('checked')) {
            jQuery('.saleTypeSection').hide();
            jQuery('.auctionSection').show();
            jQuery('.termsSection').show();
            // 販売しないにチェックがついている場合
        } else {
            jQuery('.saleTypeSection').hide();
            jQuery('.termsSection').hide();
            jQuery('.notForSaleSection').show();
        }
    });
});

// 入力項目のフォーカスが外れた際に処理を実行(post.html）
jQuery(function($) {
    // タイトルのフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#postTitle').on('blur', function() {
        checkSaleType();
        inputPostTitle();
    });
    // 販売価格のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#imagePrice').on('blur', function() {
        checkSaleType();
        inputImagePrice();
    });
    // 即決価格のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#binPrice').on('blur', function() {
        checkSaleType();
        inputBinPrice();
    });
    // オークション開始日時(年)のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#auctionDateY').on('blur', function() {
        checkSaleType();
        typeAuctionStartDateMsg();
    });
    // オークション開始日時(月)のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#auctionDateM').on('blur', function() {
        checkSaleType();
        typeAuctionStartDateMsg();
    });
    // オークション開始日時(日)のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#auctionDateD').on('blur', function() {
        checkSaleType();
        typeAuctionStartDateMsg();
    });
    // オークション開始日時(時)のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#auctionDateH').on('blur', function() {
        checkSaleType();
        typeAuctionStartDateMsg();
    });
    // オークション開始日時(分)のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#auctionDateMin').on('blur', function() {
        checkSaleType();
        typeAuctionStartDateMsg();
    });
    // オークション終了日時(年)のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#auctionEndDateY').on('blur', function() {
        checkSaleType();
        typeAuctionEndDateMsg();
    });
    // オークション終了日時(月)のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#auctionEndDateM').on('blur', function() {
        checkSaleType();
        typeAuctionEndDateMsg();
    });
    // オークション終了日時(日)のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#auctionEndDateD').on('blur', function() {
        checkSaleType();
        typeAuctionEndDateMsg();
    });
    // オークション終了日時(時)のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#auctionEndDateH').on('blur', function() {
        checkSaleType();
        typeAuctionEndDateMsg();
    });
    // オークション終了日時(分)のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#auctionEndDateMin').on('blur', function() {
        checkSaleType();
        typeAuctionEndDateMsg();
    });
    // 利用規約にチェックされた際にcheck_ProfileInput実行
    jQuery('#postTermsCheck').on('click', function() {
        checkSaleType();
    });
    // 通常販売クリック時に
    jQuery('#sale').on('click', function() {
        checkSaleType();
    });
    // オークションクリック時に
    jQuery('#auction').on('click', function() {
        checkSaleType();
    });
    // 販売しないクリック時に
    jQuery('#notForSale').on('click', function() {
        checkSaleType();
    });
    // 画像選択時
    jQuery('#postFile').change(function() {
        checkSaleType();
    });
    jQuery('#postFile2').change(function() {
        checkSaleType();
    });
    jQuery('#postFile3').change(function() {
        checkSaleType();
    });
    // 開始時間指定クリック時
    jQuery('#specify').on('click', function() {
        checkSaleType();
    });
    // オークション開始日時、指定しないクリック時
    jQuery('#notSpecified').on('click', function() {
        checkSaleType();
    });
});

// 通常販売時
function checkSaleInput() {
    // 新規登録ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    // var flagPostFile = false;
    var flagPostFile = true;
    var flagPostTitle = false;
    var flagImagePrice = false;
    var flagBinPrice = false;
    var flagPostTerms = false;

    // 画像ファイル名取得
    // var postFileVal = jQuery('#postFile').val();
    // var postFile2Val = jQuery('#postFile2').val();
    // var postFile3Val = jQuery('#postFile3').val();
    // タイトルの値取得
    var postTitleVal = jQuery('#postTitle').val();
    // 販売価格の値取得
    var imagePriceVal = jQuery('#imagePrice').val();
    // 即決価格の値取得
    var binPriceVal = jQuery('#binPrice').val();

    // 画像が選択されているかを確認
    // if (postFileVal.length > 0 || postFile2Val.length > 0 || postFile3Val.length > 0) {
    //     jQuery('#selectPostFileMsg').hide();
    //     flagPostFile = true;
    // } else {
    //     selectPostFileMsg();
    //     this.value = '';
    //     jQuery('#cover_img').addClass('d-none');
    // }
    // タイトルが入力されているかを確認
    if (postTitleVal.length > 0) {
        jQuery('#inputPostTitleMsg').hide();
        // タイトルに空白文字が含まれていないかを確認
        if (!postTitleVal.match(/[\x20\u3000]/)) {
            flagPostTitle = true;
        }
    }

    // 販売価格が入力されているかを確認
    if (imagePriceVal.length > 0) {
        jQuery('#inputImagePriceMsg').hide();
        // 販売価格に空白文字が含まれていないかを確認
        if (!imagePriceVal.match(/[\x20\u3000]/)) {
            flagImagePrice = true;
        }
    }
    // 即決価格が入力されているかを確認
    if (binPriceVal.length > 0) {
        jQuery('#inputBinPriceMsg').hide();
        // 即決価格に空白文字が含まれていないかを確認
        if (!binPriceVal.match(/[\x20\u3000]/)) {
            flagBinPrice = true;
        }
    }

    var postTermsCheck = document.getElementById('postTermsCheck');

    if (flagPostFile === true && flagPostTitle === true && flagImagePrice === true && flagBinPrice === true && postTermsCheck.checked === true) {
        disabledFlag = false;
    }
    jQuery('#postBtn').attr('disabled', disabledFlag);
}

// オークション選択時
function checkAuctionInput() {
    // 新規登録ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    // var flagPostFile = false;
    var flagPostFile = true;
    var flagPostTitle = false;
    var flagAuctionStartDate = false;
    var flagAuctionEndDate = false;

    // 画像ファイル名取得
    //    var postFileVal = jQuery('#postFile').val();
    //    var postFile2Val = jQuery('#postFile2').val();
    //    var postFile3Val = jQuery('#postFile3').val();
    // タイトルの値取得
    var postTitleVal = jQuery('#postTitle').val();
    // オークション開始日時(年)の値取得
    var auctionDateYVal = jQuery('#auctionDateY').val();
    // オークション開始日時(月)の値取得
    var auctionDateMVal = jQuery('#auctionDateM').val();
    // オークション開始日時(日)の値取得
    var auctionDateDVal = jQuery('#auctionDateD').val();
    // オークション開始日時(時)の値取得
    var auctionDateHVal = jQuery('#auctionDateH').val();
    // オークション開始日時(分)の値取得
    var auctionDateMinVal = jQuery('#auctionDateMin').val();
    // オークション終了日時(年)の値取得
    var auctionEndDateYVal = jQuery('#auctionEndDateY').val();
    // オークション終了日時(月)の値取得
    var auctionEndDateMVal = jQuery('#auctionEndDateM').val();
    // オークション終了日時(日)の値取得
    var auctionEndDateDVal = jQuery('#auctionEndDateD').val();
    // オークション終了日時(時)の値取得
    var auctionEndDateHVal = jQuery('#auctionEndDateH').val();
    // オークション終了日時(分)の値取得
    var auctionEndDateMinVal = jQuery('#auctionEndDateMin').val();

    // 画像が選択されているかを確認
    //if (postFileVal.length > 0 || postFile2Val.length > 0 || postFile3Val.length > 0) {
    //    jQuery('#selectPostFileMsg').hide();
    flagPostFile = true;
    //} else {
    //    selectPostFileMsg();
    //    this.value = '';
    //    jQuery('#cover_img').addClass('d-none');
    //}

    // タイトルが入力されているかを確認
    if (postTitleVal.length > 0) {
        // タイトルに空白文字が含まれていないかを確認
        if (!postTitleVal.match(/[\x20\u3000]/)) {
            flagPostTitle = true;
        }
    }

    // オークション開始日時が指定されている場合
    if (jQuery('#specify').prop('checked')) {
        // オークション開始日時（年）が入力されている場合
        if (auctionDateYVal.length > 0) {
            // 年のフォーマットを確認
            yearValidated = validateYear(auctionDateYVal);
            if (yearValidated === true) {
                // 年のフォーマットが正しい場合、エラーメッセージを非表示
                jQuery('#dateFormatYErrMsg').hide();
                // オークション開始日時（月）が入力されている場合
                if (auctionDateMVal.length > 0) {
                    // 月のフォーマットを確認
                    monthValidated = validateMonth(auctionDateMVal);
                    if (monthValidated === true) {
                        // 月のフォーマットが正しい場合、エラーメッセージを非表示
                        jQuery('#dateFormatMErrMsg').hide();
                        // オークション開始日時（日）が入力されている場合
                        if (auctionDateDVal.length > 0) {
                            // 日のフォーマットを確認
                            dayValidated = validateDay(auctionDateDVal);
                            if (dayValidated === true) {
                                // 日のフォーマットが正しい場合、エラーメッセージを非表示
                                jQuery('#dateFormatDErrMsg').hide();
                                // オークション開始日時（時）が入力されている場合
                                if (auctionDateHVal.length > 0) {
                                    // 日のフォーマットを確認
                                    hrsValidated = validateHrs(auctionDateHVal);
                                    if (hrsValidated === true) {
                                        // 時のフォーマットが正しい場合、エラーメッセージを非表示
                                        jQuery('#dateFormatHErrMsg').hide();
                                        // オークション開始日時（分）が入力されている場合
                                        if (auctionDateMinVal.length > 0) {
                                            // 分のフォーマットを確認
                                            minValidated = validateMin(auctionDateMinVal);
                                            if (minValidated === true) {
                                                // 分のフォーマットが正しい場合、エラーメッセージを非表示
                                                jQuery('#dateFormatMinErrMsg').hide();
                                                // オークション開始日時フラグをtrueに設定
                                                flagAuctionStartDate = true;
                                                // 年月日が設定されている場合、エラーメッセージを非表示
                                                jQuery('#inputAppDeadlineMsg').hide();
                                            } else {
                                                dateFormatMinInvalidMsg();
                                            }
                                        }
                                    } else {
                                        dateFormatHInvalidMsg();
                                    }
                                }
                            } else {
                                dateFormatDInvalidMsg();
                            }
                        }
                    } else {
                        dateFormatMInvalidMsg();
                    }
                }
            } else {
                dateFormatYInvalidMsg();
            }
        }

        // オークション終了日時（年）が入力されている場合
        if (auctionEndDateYVal.length > 0) {
            // 年のフォーマットを確認
            yearValidated = validateYear(auctionEndDateYVal);
            if (yearValidated === true) {
                // 年のフォーマットが正しい場合、エラーメッセージを非表示
                jQuery('#auctionEndYErrMsg').hide();
                // オークション終了日時（月）が入力されている場合
                if (auctionEndDateMVal.length > 0) {
                    // 月のフォーマットを確認
                    monthValidated = validateMonth(auctionEndDateMVal);
                    if (monthValidated === true) {
                        // 月のフォーマットが正しい場合、エラーメッセージを非表示
                        jQuery('#auctionEndMErrMsg').hide();
                        // オークション開始日時（日）が入力されている場合
                        if (auctionEndDateDVal.length > 0) {
                            // 日のフォーマットを確認
                            dayValidated = validateDay(auctionEndDateDVal);
                            if (dayValidated === true) {
                                // 日のフォーマットが正しい場合、エラーメッセージを非表示
                                jQuery('#auctionEndDErrMsg').hide();
                                // オークション開始日時（時）が入力されている場合
                                if (auctionDateHVal.length > 0) {
                                    // 時のフォーマットを確認
                                    hrsValidated = validateHrs(auctionEndDateHVal);
                                    if (hrsValidated === true) {
                                        // 時のフォーマットが正しい場合、エラーメッセージを非表示
                                        jQuery('#auctionEndHErrMsg').hide();
                                        // オークション開始日時（分）が入力されている場合
                                        if (auctionEndDateMinVal.length > 0) {
                                            // 分のフォーマットを確認
                                            minValidated = validateMin(auctionEndDateMinVal);
                                            if (minValidated === true) {
                                                // 分のフォーマットが正しい場合、エラーメッセージを非表示
                                                jQuery('#auctionEndMinErrMsg').hide();
                                                // オークション開始日時フラグをtrueに設定
                                                flagAuctionEndDate = true;
                                                // 年月日が設定されている場合、エラーメッセージを非表示
                                                jQuery('#auctionEndErrMsg').hide();
                                            } else {
                                                auctionEndMinInvalidMsg();
                                            }
                                        }
                                    } else {
                                        auctionEndHInvalidMsg();
                                    }
                                }
                            } else {
                                auctionEndDInvalidMsg();
                            }
                        }
                    } else {
                        auctionEndMInvalidMsg();
                    }
                }
            } else {
                auctionEndYInvalidMsg();
            }
        }
        // オークション開始日時が指定されていない場合
    } else {
        flagAuctionStartDate = true;
        flagAuctionEndDate = true;
    }

    var postTermsCheck = document.getElementById('postTermsCheck');

    if (flagPostTitle === true && flagAuctionStartDate === true && flagAuctionEndDate === true && postTermsCheck.checked === true) {
        disabledFlag = false;
    }
    jQuery('#postBtn').attr('disabled', disabledFlag);
}

// 販売しない時選択時
function checkNotForSaleInput() {
    // 画像投稿確認ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    // var flagPostFile = false;
    var flagPostFile = true;
    var flagPostTitle = false;

    // 画像ファイル名取得
    // var postFileVal = jQuery('#postFile').val();
    // var postFile2Val = jQuery('#postFile2').val();
    // var postFile3Val = jQuery('#postFile3').val();
    // タイトルの値取得
    var postTitleVal = jQuery('#postTitle').val();

    // 画像が選択されているかを確認
    // if (postFileVal.length > 0 || postFile2Val.length > 0 || postFile3Val.length > 0) {
    //     jQuery('#selectPostFileMsg').hide();
    //     flagPostFile = true;
    // } else {
    //     selectPostFileMsg();
    //     this.value = '';
    //     jQuery('#cover_img').addClass('d-none');
    // }
    // タイトルが入力されているかを確認
    if (postTitleVal.length > 0) {
        jQuery('#inputPostTitleMsg').hide();
        // タイトルに空白文字が含まれていないかを確認
        if (!postTitleVal.match(/[\x20\u3000]/)) {
            flagPostTitle = true;
        }
    } else {
        inputPostTitle();
    }

    // 必須の入力項目が入力されている場合、ボタン有効化フラグをfalseに設定
    if (flagPostFile === true && flagPostTitle === true) {
        disabledFlag = false;
    }
    jQuery('#postBtn').attr('disabled', disabledFlag);
}

// 販売形式確認
function checkSaleType() {
    var getSaleType = '';
    if (jQuery('#sale').prop('checked')) {
        getSaleType = checkSaleInput();
    } else if (jQuery('#auction').prop('checked')) {
        getSaleType = checkAuctionInput();
    } else {
        getSaleType = checkNotForSaleInput();
    }
    return getSaleType;
}

function selectPostFileMsg() {
    // 画像ファイル選択されてない際のメッセージ
    var postFileLength = jQuery('#postFile').val().length;
    if (postFileLength <= 0) {
        jQuery('#selectPostFile').empty().append("<p id=\"selectPostFileMsg\" class=\"selectPostFileMsg postErrMsg mb-0\">画像を選択してください</p>");
    }
}

function inputPostTitle() {
    // タイトルが入力されてない際のメッセージ
    var postTitleLength = jQuery('#postTitle').val().length;
    if (postTitleLength <= 0) {
        jQuery('#inputPostTitle').empty().append("<p id=\"inputPostTitleMsg\" class=\"inputPostTitleMsg postErrMsg my-0\">タイトルを入力して下さい</p>");
    }
}

function inputImagePrice() {
    // 販売価格が入力されてない際のメッセージ
    var imagePriceLength = jQuery('#imagePrice').val().length;
    if (imagePriceLength <= 0) {
        jQuery('#inputImagePrice').empty().append("<p id=\"inputImagePriceMsg\" class=\"inputImagePriceMsg postErrMsg my-0\">販売価格を入力して下さい</p>");
    }
}

function inputBinPrice() {
    // タイトルが入力されてない際のメッセージ
    var binPriceLength = jQuery('#binPrice').val().length;
    if (binPriceLength <= 0) {
        jQuery('#inputBinPrice').empty().append("<p id=\"inputBinPriceMsg\" class=\"inputBinPriceMsg postErrMsg my-0\">即決価格を入力して下さい</p>");
    }
}
// オークション開始日時が入力されていない場合、メッセージを表示
function typeAuctionStartDateMsg() {
    // オークション開始日時(年)の値取得
    var auctionDateYVal = jQuery('#auctionDateY').val().length;
    // オークション開始日時(月)の値取得
    var auctionDateMVal = jQuery('#auctionDateM').val().length;
    // オークション開始日時(日)の値取得
    var auctionDateDVal = jQuery('#auctionDateD').val().length;
    // オークション開始日時(時)の値取得
    var auctionDateHVal = jQuery('#auctionDateH').val().length;
    // オークション開始日時(分)の値取得
    var auctionDateMinVal = jQuery('#auctionDateMin').val().length;

    // オークション開始日時の年月日時間分がそれぞれ入力されていない場合、エラーメッセージを表示
    if (auctionDateYVal <= 0 || auctionDateMVal <= 0 || auctionDateDVal <= 0 || auctionDateHVal <= 0 || auctionDateMinVal <= 0) {
        jQuery('#inputAppDeadline').empty().append("<p id=\"inputAppDeadlineMsg\" class=\"inputRequestErrMsg mt-1\">オークション開始日時を入力してください</p>");
    }
}
// オークション終了日時が入力されていない場合、メッセージを表示
function typeAuctionEndDateMsg() {
    // オークション開始日時(年)の値取得
    var auctionDateYVal = jQuery('#auctionEndDateY').val().length;
    // オークション開始日時(月)の値取得
    var auctionDateMVal = jQuery('#auctionEndDateM').val().length;
    // オークション開始日時(日)の値取得
    var auctionDateDVal = jQuery('#auctionEndDateD').val().length;
    // オークション開始日時(時)の値取得
    var auctionDateHVal = jQuery('#auctionEndDateH').val().length;
    // オークション開始日時(分)の値取得
    var auctionDateMinVal = jQuery('#auctionEndDateMin').val().length;

    // オークション開始日時の年月日時間分がそれぞれ入力されていない場合、エラーメッセージを表示
    if (auctionDateYVal <= 0 || auctionDateMVal <= 0 || auctionDateDVal <= 0 || auctionDateHVal <= 0 || auctionDateMinVal <= 0) {
        jQuery('#inputAuctionEnd').empty().append("<p id=\"auctionEndErrMsg\" class=\"inputRequestErrMsg mt-1\">オークション開始日時を入力してください</p>");
    }
}
// オークション開始日時（時）のフォーマットが正しくない場合、メッセージを表示
function dateFormatHInvalidMsg() {
    jQuery('#inputAppDeadline').empty().append("<p id=\"dateFormatHErrMsg\" class=\"inputRequestErrMsg mt-1\">時のフォーマットが正しくありません</p>");
}
// オークション開始日時（分）のフォーマットが正しくない場合、メッセージを表示
function dateFormatMinInvalidMsg() {
    jQuery('#inputAppDeadline').empty().append("<p id=\"dateFormatMinErrMsg\" class=\"inputRequestErrMsg mt-1\">分のフォーマットが正しくありません</p>");
}

// オークション終了日時（年）のフォーマットが正しくない場合、メッセージを表示
function auctionEndYInvalidMsg() {
    jQuery('#inputAuctionEnd').empty().append("<p id=\"auctionEndYErrMsg\" class=\"inputRequestErrMsg mt-1\">年のフォーマットが正しくありません</p>");
}
// オークション終了日時（月）のフォーマットが正しくない場合、メッセージを表示
function auctionEndMInvalidMsg() {
    jQuery('#inputAuctionEnd').empty().append("<p id=\"auctionEndMErrMsg\" class=\"inputRequestErrMsg mt-1\">月のフォーマットが正しくありません</p>");
}
// オークション終了日時（日）のフォーマットが正しくない場合、メッセージを表示
function auctionEndDInvalidMsg() {
    jQuery('#inputAuctionEnd').empty().append("<p id=\"auctionEndDErrMsg\" class=\"inputRequestErrMsg mt-1\">日のフォーマットが正しくありません</p>");
}
// オークション終了日時（時）のフォーマットが正しくない場合、メッセージを表示
function auctionEndHInvalidMsg() {
    jQuery('#inputAuctionEnd').empty().append("<p id=\"auctionEndHErrMsg\" class=\"inputRequestErrMsg mt-1\">時のフォーマットが正しくありません</p>");
}
// オークション終了日時（分）のフォーマットが正しくない場合、メッセージを表示
function auctionEndMinInvalidMsg() {
    jQuery('#inputAuctionEnd').empty().append("<p id=\"auctionEndMinErrMsg\" class=\"inputRequestErrMsg mt-1\">分のフォーマットが正しくありません</p>");
}

jQuery(function($) {
    jQuery('#terms_service').click(function() {
        let termsChecked = jQuery('#terms_service').get(0).checked;
        if (termsChecked === true) {
            jQuery('#save_btn').attr('disabled', false);
        } else {
            jQuery('#save_btn').attr('disabled', true);
        }
    });
});

/**
 * 画像投稿ページ(post.html)
 */
jQuery(function($) {
    // 投稿画像を表示
    jQuery('#postFile').change(function() {
        let file = this.files[0];
        if (file) {
            let fr = new FileReader();
            fr.readAsDataURL(file);
            fr.onload = function() {
                jQuery('#cover_img').attr('src', fr.result);
                jQuery('#cover_img').removeClass('d-none')
            }
        }
    });
    // オークション開始日時指定の表示切替
    jQuery('[name="auctionStartDate"]:radio').change(function() {
        if (jQuery('#specify').prop('checked')) {
            jQuery('#auction_datetime').removeClass('d-none');
        } else {
            jQuery('#auction_datetime').addClass('d-none');
        }
    });
});