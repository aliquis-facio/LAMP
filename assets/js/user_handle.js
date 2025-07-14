function sign_in_submit() {
	let form = document.getElementById("sign_in_form");
    let inputs = document.getElementsByTagName("input");
    let check = true;

    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value == "") {
            alert("You can't leave this empty");
            check = false;
            break;
        }
    }

    if (check) {
		form.submit();
	}
}

function sign_up_submit() {
    let form = document.getElementById("sign_up_form");
    let inputs = document.getElementsByTagName("input");
    let check = true;

    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value == "") {
            alert("You can't leave this empty");
            check = false;
            break;
        }
    }

    if (check) form.submit();
}

function update_my_inform_submit() {
    let form = document.getElementById("update_form");
    let pw = document.getElementById("pw_input").value;
    let new_pw = document.getElementById("new_pw_input").value;
    let new_pw_confirm = document.getElementById("new_pw_confirm_input").value;

    if (pw == "") {
        alert("현재 비밀번호를 입력해주세요");
    } else {
        if (new_pw == new_pw_confirm) form.submit();
        else alert("입력하신 비밀번호가 일치하지 않습니다");
    }
}

function delete_account() {
    let form = document.getElementById("delete_account_form");
    let input_pw = document.getElementsByTagName('input')[0].value;

    if (input_pw == "") {
        alert("현재 비밀번호를 입력해주세요");
    } else {
        let check = confirm("정말로 탈퇴하시겠습니까?");
        if (check) form.submit();
    }
}

function is_email(string) {
	var regExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
 
	return regExp.test(string);
}

function is_password(string) {
    // 8 ~ 16자 영문, 숫자 조합
	var regExp = /^(?=.*\d)(?=.*[a-zA-Z])[0-9a-zA-Z]{8,16}$/;
 
	return regExp.test(string);
}

function is_password(string) {
    // 8 ~ 16자 영문, 숫자, 특수문자를 최소 한가지씩 조합
	var regExp = /^(?=.*[a-zA-z])(?=.*[0-9])(?=.*[$`~!@$!%*#^?&\\(\\)\-_=+]).{8,16}$/;
 
	return regExp.test(string); // 형식에 맞는 경우 true 리턴
}

function is_phone_number(string) {
	var regExp = /^01(?:0|1|[6-9])-(?:\d{3}|\d{4})-\d{4}$/;
 
	return regExp.test(string);
}

function is_id(string) {
    // 영문자로 시작하는 영문자 또는 숫자 6~20자 
	var regExp = /^[a-z]+[a-z0-9]{5,19}$/g;
 
	return regExp.test(string);
}

function isCorrect(string) {
    // 한글, 영문
	var regExp = /^[a-zA-Zㄱ-힣][a-zA-Zㄱ-힣 ]*$/;
 
	return regExp.test(string);
}

function isCorrect(string) {
    // 영문 대문자, 소문자, 숫자, 문자 사이 공백 및 특수문자 -_/,.
	var regExp = /^[a-zA-Z0-9-_/,.][a-zA-Z0-9-_/,. ]*$/;
    
	return regExp.test(string);
}

function isCorrect(string) {
    // 영문 대문자, 소문자, 문자사이 공백
	var regExp = /^[a-zA-Z][a-zA-Z ]*$/;
    
	return regExp.test(string);
}

function isCorrect(string) {
    // 한글만 입력
	var regExp = /[ㄱ-힣]/;
    
	return regExp.test(string);
}

function isCorrect(string) {
    // 한글, 특수문자만 입력
	var regExp = /^[ㄱ-힣\{\}\[\]\/?.,;:|\)*~`!^\-_+<>@\#$%&\\\=\(\'\" ]*$/;
    
	return regExp.test(string);
}

