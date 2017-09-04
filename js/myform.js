function formInputFocus(idInput) {
    var Parent = document.getElementById(idInput).parentElement.id;
    var ParentId = document.getElementById(Parent);
    ParentId.classList.add("focused-input");
};
function formInputBlur(idInput) {
    var idUse = document.getElementById(idInput);
    var Parent = idUse.parentElement.id;
    var ParentId = document.getElementById(Parent);
    if(idUse.value == 0)
    {
        ParentId.classList.remove("focused-input");
    }
};
function formInputShow(idInput){
    var idUse = document.getElementById(idInput);
    var Parent = idUse.parentElement.id;
    var ParentId = document.getElementById(Parent);
    ParentId.classList.add("focused-input");
};