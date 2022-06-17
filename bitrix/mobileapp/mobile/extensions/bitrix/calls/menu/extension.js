(function ()
{
	const DoNothing = function(){};
	const Icons = {
		hand: `<svg width="17" height="22" viewBox="0 0 17 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.31539 0.14209C9.96749 0.14209 10.5141 0.589043 10.6593 1.19021L10.6592 9.80171C10.6592 9.94349 10.773 10.059 10.9151 10.0637L10.9242 10.0639H11.0378C11.1811 10.0639 11.2978 9.95134 11.3026 9.81073L11.3027 9.80171L11.3027 3.6293C11.511 3.16182 11.9835 2.83548 12.533 2.83548C13.1657 2.83548 13.6962 3.26804 13.839 3.85055L13.839 11.1875C13.839 11.3292 13.9527 11.4447 14.0949 11.4495L14.104 11.4496H14.2175C14.3608 11.4496 14.4776 11.3371 14.4824 11.1965L14.4825 11.1875V7.33013C14.4825 6.69925 14.9994 6.18782 15.6371 6.18782C16.2747 6.18782 16.668 6.69925 16.668 7.33013V10.7006C16.668 10.7006 16.6533 13.094 16.5306 14.233C16.408 15.3721 15.9567 18.3943 14.25 21.0497C14.162 21.1866 14.0112 21.2708 13.848 21.2752L13.8347 21.2754H6.25069C6.09953 21.2754 5.95703 21.2066 5.86389 21.0895L5.85557 21.0787L0.240826 13.5957C0.0617091 13.357 0.101585 13.0215 0.331794 12.8304C0.601759 12.6064 0.883872 12.4728 1.17813 12.4297L1.32964 12.4075C1.89283 12.3261 2.27105 12.3006 3.05537 12.7587C3.61661 13.0865 4.12653 13.6741 4.58513 14.5214L4.60252 14.5537V3.60327C4.60252 2.84828 5.22112 2.23624 5.9842 2.23624H6.02206C6.67416 2.23624 7.22074 2.68319 7.36595 3.28436L7.36589 9.20247C7.36589 9.34424 7.47963 9.45973 7.62176 9.46449L7.74443 9.46464C7.88773 9.46464 8.00446 9.3521 8.00926 9.21148L8.00941 9.20247L8.00938 0.965569C8.22184 0.481019 8.70968 0.14209 9.27754 0.14209H9.31539Z" fill="#767C87"/></svg>`,
		returnToSpeaker: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.4588 11.8799C13.4588 11.8799 13.4551 12.0054 13.4606 12.1594L13.2351 12.2074L6.2806 19.0482L7.20653 20H1C1 20 1.12449 18.0718 1.46305 16.7352C1.80161 15.3986 3.70608 14.4059 5.45844 13.6425C5.91726 13.4426 6.19427 13.283 6.47412 13.1219L6.47413 13.1219L6.47414 13.1219C6.74751 12.9645 7.02362 12.8055 7.4746 12.6057C7.52581 12.3596 7.54639 12.1081 7.53588 11.857L8.3121 11.7637C8.3121 11.7637 8.41423 11.9516 8.25039 10.8474C8.25039 10.8474 7.37812 10.6185 7.3377 8.86023C7.3377 8.86023 6.68187 9.08098 6.64232 8.01566C6.63414 7.80339 6.57997 7.59931 6.52808 7.40377C6.4036 6.93473 6.29217 6.51485 6.85963 6.14898L6.45022 5.04348C6.45022 5.04348 6.01952 0.774424 7.90704 1.12003C7.14125 -0.10859 13.5996 -1.12985 14.0286 2.63204C14.1973 3.76607 14.1973 4.91861 14.0286 6.05264C14.0286 6.05264 14.9934 5.94032 14.3493 7.79793C14.3493 7.79793 13.9947 9.13498 13.4501 8.83474C13.4501 8.83474 13.5383 10.5243 12.6808 10.8107C12.6808 10.8107 12.7421 11.7106 12.7421 11.7715L13.4588 11.8799ZM18.1246 11.2101H19.62C21.9672 11.2101 23.87 13.1129 23.87 15.4601V15.8556C23.87 18.2028 21.9672 20.1056 19.62 20.1056H14.8506V23.9655L9.80676 18.9217L14.8506 13.8779V17.6056H19.62C20.5865 17.6056 21.37 16.8221 21.37 15.8556V15.4601C21.37 14.4936 20.5865 13.7101 19.62 13.7101H18.1246V11.2101Z" fill="#767C87"/></svg>`,
		participants: `<svg width="22" height="17" viewBox="0 0 22 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.133 11.7773C14.133 11.7773 14.8798 14.5169 15.1651 16.0886C13.2222 16.542 10.9715 16.8012 8.57234 16.8012C5.57658 16.8012 2.81236 16.3971 0.589844 15.7154C0.824966 14.5294 1.16747 12.8363 1.32213 12.2412C1.56958 11.289 2.95604 10.5815 4.23128 10.0377C4.56464 9.89559 4.76575 9.78214 4.96899 9.6675C5.16804 9.55521 5.36913 9.44177 5.69851 9.29916C5.73569 9.1241 5.75063 8.94527 5.74301 8.76667L6.30807 8.70011C6.30807 8.70011 6.38233 8.8339 6.26289 8.04714C6.26289 8.04714 5.62869 7.88239 5.59926 6.6297C5.59926 6.6297 5.12285 6.78712 5.0941 6.02798C5.08825 5.87615 5.04886 5.73027 5.01113 5.59057C4.92078 5.25597 4.84002 4.95689 5.2529 4.69675L4.9548 3.90999C4.9548 3.90999 4.64198 0.866783 6.01578 1.11439C5.45859 0.240104 10.1591 -0.487417 10.4712 2.19303C10.5941 3.00102 10.5941 3.82219 10.4712 4.63019C10.4712 4.63019 11.1735 4.55031 10.7046 5.87356C10.7046 5.87356 10.4466 6.82473 10.0503 6.61007C10.0503 6.61007 10.1146 7.81384 9.49033 8.01785C9.49033 8.01785 9.53482 8.65884 9.53482 8.70244L10.0568 8.78131C10.0568 8.78131 10.0424 9.3158 10.1451 9.37371C10.6208 9.67837 11.1424 9.90932 11.691 10.0583C13.3116 10.4657 14.133 11.1649 14.133 11.7773Z" fill="#767C87"/><path d="M21.336 12.3792C21.3587 12.8187 21.3871 13.3674 21.4115 13.846C19.9455 14.3252 18.225 14.7072 16.3304 14.9634H15.824C15.7937 14.5456 15.4051 13.0988 15.1796 12.2592C15.0902 11.9263 15.0264 11.6889 15.0208 11.6489C14.9917 10.8582 14.2774 10.152 13.0563 9.6694C13.1486 9.54778 13.2278 9.41717 13.2924 9.27968C13.4637 9.07271 13.6869 8.91223 13.9406 8.81374L13.9601 8.19472L12.6195 7.7867C12.6195 7.7867 12.2749 7.62994 12.2407 7.62994C12.2803 7.5347 12.33 7.4437 12.3889 7.35837C12.4145 7.29181 12.5768 6.79526 12.5768 6.79526C12.3815 7.03947 12.1526 7.25629 11.8964 7.43958C12.1309 7.03614 12.3298 6.61406 12.4909 6.1779C12.5971 5.75807 12.6683 5.33057 12.7037 4.89958C12.7956 4.11635 12.9389 3.33965 13.1329 2.57424C13.2722 2.1923 13.5175 1.85535 13.8417 1.60078C14.3208 1.27709 14.88 1.08351 15.4616 1.03999H15.5301C16.1127 1.08315 16.673 1.27674 17.153 1.60078C17.4776 1.85486 17.7231 2.19166 17.8622 2.57358C18.056 3.33904 18.1994 4.11572 18.2917 4.89891C18.333 5.32034 18.4077 5.73804 18.5152 6.14828C18.6762 6.59214 18.8716 7.02348 19.0998 7.43858C18.843 7.25577 18.6136 7.03927 18.418 6.79526C18.418 6.79526 18.5443 7.24588 18.5696 7.31244C18.639 7.41302 18.7007 7.51836 18.7544 7.62761C18.7212 7.62761 18.3755 7.78437 18.3755 7.78437L17.0349 8.19239L17.0541 8.81175C17.308 8.90994 17.5313 9.07048 17.7023 9.27768C17.7835 9.47655 17.9119 9.6539 18.0771 9.7952C18.4005 9.90476 18.7124 10.0443 19.0084 10.2119C19.4565 10.4544 19.9483 10.6112 20.4571 10.6738C20.9705 10.756 21.2943 11.5631 21.2943 11.5631C21.2943 11.571 21.3118 11.9108 21.3357 12.3728L21.336 12.3792Z" fill="#767C87"/></svg>`,
		copyInvite: `<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M16.39 8.17901L13.1048 11.4631C11.2917 13.2773 8.3503 13.2773 6.53684 11.4631C6.25119 11.1782 6.02773 10.8573 5.83148 10.5263L7.35791 9C7.43047 8.92683 7.52007 8.8849 7.60569 8.83551C7.71122 9.19605 7.89544 9.53737 8.17898 9.82096C9.08448 10.7272 10.5579 10.7259 11.4629 9.82096L14.747 6.53696C15.6532 5.63085 15.6532 4.15776 14.747 3.25234C13.842 2.34692 12.369 2.34692 11.4629 3.25234L10.295 4.42143C9.34735 4.05243 8.32633 3.95322 7.33237 4.09887L9.82093 1.6104C11.6352 -0.203467 14.5758 -0.203467 16.39 1.6104C18.2033 3.42419 18.2033 6.36526 16.39 8.17901ZM7.70548 13.5791L6.5368 14.7482C5.63138 15.6532 4.15787 15.6532 3.25229 14.7482C2.34679 13.842 2.34679 12.3689 3.25229 11.4631L6.5368 8.17901C7.44296 7.27298 8.91547 7.27298 9.82089 8.17901C10.1038 8.46198 10.2882 8.80323 10.3947 9.16331C10.4808 9.11327 10.5693 9.0726 10.6418 8.99997L12.1682 7.47427C11.9732 7.14199 11.7486 6.82218 11.4628 6.53703C9.64981 4.72317 6.70815 4.72317 4.89428 6.53703L1.61026 9.82115C-0.203421 11.6356 -0.203421 14.5758 1.61026 16.39C3.42414 18.2033 6.36511 18.2033 8.17894 16.39L10.6682 13.901C9.67367 14.0475 8.65237 13.9475 7.70548 13.5791Z" fill="#767C87"/></svg>`,
		chat: `<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 1.78482C0 0.799093 0.804841 0 1.79766 0H15.2023C16.1952 0 17 0.799093 17 1.78482V11.1987C17 12.1844 16.1952 12.9835 15.2023 12.9835H7.93077L3.92308 17V12.9835H1.79766C0.804842 12.9835 0 12.1844 0 11.1987V1.78482Z" fill="#767C87"/></svg>`,
		pin: `<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M21.267 6.37466C21.8197 6.92861 21.791 7.85343 21.203 8.4403C20.6149 9.02717 19.6901 9.05386 19.1374 8.4999L18.1065 7.46891L11.5476 16.0682L12.5541 17.0747C13.0704 17.6344 13.0267 18.5293 12.4551 19.1009C11.8836 19.6724 10.9886 19.7162 10.429 19.1999L7.97042 16.7458L1.63585 21.5166C1.54166 21.6219 1.39988 21.6696 1.26773 21.6406C1.13558 21.6115 1.03486 21.5105 1.0062 21.3783C0.977541 21.246 1.02568 21.1043 1.13119 21.0104L5.83151 14.6039L3.42193 12.1958C2.89511 11.6377 2.93458 10.7342 3.51093 10.1582C4.08728 9.58224 4.99082 9.54342 5.54853 10.0707L6.55508 11.0772L15.1558 4.5183L14.132 3.4945C13.6052 2.93638 13.6447 2.03283 14.221 1.45687C14.7974 0.88091 15.7009 0.842094 16.2586 1.36934L21.267 6.37466Z" fill="#767C87"/></svg>`,
		unpin: `<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.1871 13.9186L18.6471 19.3785L20.4313 17.5943L4.95386 2.11681L3.1696 3.90106L8.70569 9.43716L6.55508 11.0772L5.54853 10.0707C4.99082 9.54342 4.08728 9.58224 3.51093 10.1582C2.93458 10.7342 2.89511 11.6377 3.42193 12.1958L5.83151 14.6039L1.13119 21.0104C1.02568 21.1043 0.977541 21.246 1.0062 21.3783C1.03486 21.5105 1.13558 21.6115 1.26773 21.6406C1.39988 21.6696 1.54166 21.6219 1.63585 21.5166L7.97042 16.7458L10.429 19.1999C10.9886 19.7162 11.8836 19.6724 12.4551 19.1009C13.0267 18.5293 13.0704 17.6344 12.5541 17.0747L11.5476 16.0682L13.1871 13.9186Z" fill="#767C87"/><path d="M18.1065 7.46892L15.8453 10.4335L12.1911 6.77921L15.1558 4.5183L14.132 3.4945C13.6052 2.93638 13.6447 2.03283 14.221 1.45687C14.7974 0.88091 15.7009 0.842094 16.2586 1.36934L21.267 6.37466C21.8197 6.92861 21.791 7.85343 21.203 8.4403C20.6149 9.02717 19.6901 9.05386 19.1374 8.49991L18.1065 7.46892Z" fill="#767C87"/></svg>`,
		muted: `<svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.10449 10.2682V9.93415L8.72703 13.5567C8.6221 13.5667 8.51573 13.5719 8.40817 13.5719C6.5836 13.5719 5.10449 12.0928 5.10449 10.2682ZM8.42123 15.6438C9.20454 15.6438 9.89324 15.5345 10.4973 15.327L12.3369 17.1666C11.5696 17.5628 10.6934 17.8476 9.71065 17.9812L9.7097 19.5742L10.2345 19.5746C10.8374 19.5746 11.3261 20.0633 11.3261 20.6662C11.3261 21.269 10.8374 21.7577 10.2345 21.7577H6.58217C5.97932 21.7577 5.49061 21.269 5.49061 20.6662C5.49061 20.0633 5.97932 19.5746 6.58217 19.5746L7.1053 19.5742L7.10521 17.9802C2.72604 17.3888 0.487433 13.8663 0.521455 10.7158C0.528679 10.0468 1.07684 9.51036 1.74581 9.5175C2.37019 9.52432 2.87912 10.0023 2.93833 10.6099L2.94401 10.7419C2.93723 11.3704 3.28823 12.5771 3.93604 13.5156C4.86612 14.863 6.29594 15.6438 8.42123 15.6438ZM13.9557 10.2868L16.0967 12.4278C16.2404 11.8495 16.3069 11.2673 16.2949 10.7031C16.2807 10.0343 15.727 9.50358 15.0581 9.51778C14.5543 9.52848 14.1289 9.84529 13.9557 10.2868ZM5.46681 1.79793L11.7119 8.04298V3.30368C11.7119 1.47911 10.2327 0 8.40817 0C7.12597 0 6.01437 0.730454 5.46681 1.79793ZM0.273354 0.986528C-0.0911179 1.351 -0.0911179 1.94192 0.273354 2.3064L15.9935 18.0265C16.358 18.391 16.9489 18.391 17.3134 18.0265L17.447 17.8929C17.8114 17.5285 17.8114 16.9375 17.447 16.5731L1.72683 0.852923C1.36235 0.488452 0.77143 0.488452 0.406958 0.852924L0.273354 0.986528Z" fill="#FF5752"/></svg>`,
		cameraOff: `<svg width="23" height="18" viewBox="0 0 23 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M2.3379 0.53483L17.3641 15.561C17.751 15.9479 17.751 16.5753 17.3641 16.9622C16.9771 17.3492 16.3498 17.3492 15.9629 16.9622L0.936686 1.93605C0.549751 1.54911 0.549751 0.921766 0.936686 0.53483C1.32362 0.147895 1.95097 0.147895 2.3379 0.53483ZM1.7212 5.41362L11.1559 14.8494L2.77778 14.8501C2.19454 14.8501 1.72173 14.3773 1.72173 13.7941L1.7212 5.41362ZM22.9785 3.7745C22.9922 3.81059 22.9992 3.84888 22.9992 3.88748V13.2906C22.9992 13.4665 22.8566 13.6091 22.6807 13.6091C22.6421 13.6091 22.6038 13.6021 22.5677 13.5884L17.7616 11.7648C17.6379 11.7179 17.5561 11.5994 17.5561 11.4671V5.71102C17.5561 5.5787 17.6379 5.46017 17.7616 5.41324L22.5677 3.58971C22.7322 3.52731 22.9161 3.61004 22.9785 3.7745ZM6.81142 2.10583L15.4767 2.10644C16.0599 2.10644 16.5327 2.57925 16.5327 3.16249L16.5324 11.8257L6.81142 2.10583Z" fill="#FF5752"/></svg>`,
		selected: `<svg width="19" height="15" viewBox="0 0 19 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.47688 14.351L0 8.03873L2.26691 5.82945L6.47688 9.9324L16.0025 0.648926L18.2694 2.85821L6.47688 14.351Z" fill="#00ACE3"/></svg>`,
		ellipsis: `<svg width="21" height="5" fill="none" xmlns="http://www.w3.org/2000/svg"><circle r="2.5" cx="2.5" cy="2.5" fill="#A8ADB4"/><circle r="2.5" cx="10.5" cy="2.5" fill="#A8ADB4"/><circle r="2.5" cx="18.5" cy="2.5" fill="#A8ADB4"/></svg>`,
		devicePhone: `<svg width="14" height="22" viewBox="0 0 14 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.3147 0.975098L2.687 0.975098C1.63102 0.975098 0.824219 1.74129 0.824219 2.7441V19.2544C0.824219 20.1975 1.63102 21.0234 2.687 21.0234H11.3147C12.3707 21.0234 13.1775 20.1975 13.1775 19.2544V2.7441C13.1775 1.74239 12.3707 0.975098 11.3147 0.975098ZM7.00084 20.4341C6.35183 20.4341 5.82113 19.9034 5.82113 19.2544C5.82113 18.6054 6.35183 18.0747 7.00084 18.0747C7.64985 18.0747 8.18055 18.6054 8.18055 19.2544C8.18055 19.9034 7.64985 20.4341 7.00084 20.4341ZM11.4629 17.4865H2.53886V3.92381L11.464 3.92381L11.4629 17.4865Z" fill="#767C87"/></svg>`,
		deviceSpeaker: `<svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.8272 0.997559V19.9906L5.30026 15.6686L5.3013 15.3732C5.25721 15.3792 5.21221 15.3822 5.16649 15.3822H1.24768C0.695597 15.3822 0.248047 14.9347 0.248047 14.3826V6.60553C0.248047 6.05345 0.695597 5.6059 1.24768 5.6059H5.16649C5.21221 5.6059 5.25721 5.60897 5.3013 5.61491L5.30026 5.43281L11.8272 0.997559ZM18.0947 2.96883C20.1282 4.96345 21.2401 7.63402 21.2401 10.4562C21.2401 13.2783 20.1282 15.9507 18.0947 17.9435C17.7501 18.2815 17.1747 18.2815 16.7911 17.9435C16.6367 17.7553 16.5213 17.5304 16.5213 17.3041C16.5213 17.078 16.5978 16.8532 16.7896 16.665C18.5173 15.01 19.4374 12.8273 19.4374 10.4563C19.4374 8.08533 18.5173 5.9025 16.7911 4.2476C16.4464 3.90953 16.4464 3.34512 16.7911 2.96883C17.1357 2.63076 17.7111 2.63076 18.0947 2.96883ZM15.7113 6.09226C16.9011 7.25787 17.553 8.80121 17.553 10.4564C17.553 12.1116 16.9011 13.6548 15.7113 14.8221C15.3667 15.1601 14.7913 15.1601 14.4076 14.8221C14.279 14.6653 14.1785 14.482 14.1486 14.2942L14.1394 14.1809C14.1394 13.9545 14.2158 13.7296 14.4076 13.5415C15.2513 12.714 15.7113 11.6218 15.7113 10.4563C15.7113 9.28917 15.2513 8.19855 14.4076 7.37102C14.063 7.03295 14.063 6.46854 14.4076 6.09226C14.7523 5.75419 15.3277 5.75419 15.7113 6.09226Z" fill="#767C87"/></svg>`,
		deviceBlueTooth: `<svg width="15" height="23" viewBox="0 0 15 23" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.5195 15.7559L5.74231 22.701L5.74524 14.3957L2.57146 16.9098L0.930526 14.8383L5.01349 11.604L0.919279 8.36443L2.5591 6.29202L5.74721 8.81466L5.75014 0.500977L14.5181 7.44642L9.27096 11.6029L14.5195 15.7559ZM8.38987 8.92945L10.2621 7.44642L8.39092 5.96421L8.38987 8.92945ZM8.38799 14.2741L10.2606 15.7559L8.38694 17.2384L8.38799 14.2741Z" fill="#767C87"/></svg>`,
		deviceWired: `<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.13647 8.50462H4.54326C5.63735 8.50462 6.52429 9.39156 6.52429 10.4857V15.1906C6.52429 16.2847 5.63735 17.1716 4.54326 17.1716H2.06697C0.972876 17.1716 0.0859375 16.2847 0.0859375 15.1906V10.4857C0.0859375 10.4422 0.0873354 10.3991 0.0900887 10.3564L0.0900918 9.22068C0.0900658 9.1282 0.094226 7.10883 1.19474 5.06175C1.75775 4.01449 2.61961 2.93832 3.92487 2.12942C5.23435 1.31791 6.90537 0.828125 9.00059 0.828125C11.0958 0.828124 12.7668 1.31791 14.0763 2.12943C15.3816 2.93833 16.2434 4.0145 16.8065 5.06177C17.907 7.10888 17.9111 9.12815 17.9111 9.22056L17.9111 10.3566C17.9138 10.3993 17.9152 10.4423 17.9152 10.4857V15.1906C17.9152 16.2847 17.0283 17.1716 15.9342 17.1716H13.4579C12.3638 17.1716 11.4769 16.2847 11.4769 15.1906V10.4857C11.4769 9.39156 12.3638 8.50462 13.4579 8.50462H14.8647C14.7782 7.97424 14.5916 7.21739 14.1892 6.46883C13.8243 5.7901 13.2941 5.14057 12.511 4.65527C11.7321 4.17258 10.6185 3.79967 9.00059 3.79967C7.3827 3.79967 6.26906 4.17258 5.49019 4.65527C4.7071 5.14056 4.17692 5.79009 3.81204 6.46882C3.40961 7.21738 3.223 7.97424 3.13647 8.50462Z" fill="#767C87"/></svg>`,
		emptyAvatar: `<svg width="55" height="54" viewBox="0 0 55 54" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="27.5" cy="27" r="26.7" fill="#C4C4C4"/><path fill-rule="evenodd" clip-rule="evenodd" d="M24.8275 14.6978C23.8798 13.203 31.7392 11.9567 32.4892 16.3612L32.5183 16.5653C32.7304 17.966 32.7304 19.3895 32.5183 20.7902L32.5867 20.7894C32.8227 20.8016 33.5583 20.9762 32.9875 22.7497L32.8546 23.1586C32.7064 23.592 32.3202 24.513 31.7915 24.2264L31.7946 24.4308C31.7902 24.965 31.6952 26.3813 30.8251 26.667L30.9021 27.8537L31.8025 27.9876L31.8015 28.1998C31.8052 28.4797 31.8304 28.9453 31.9548 29.0148C32.7762 29.5429 33.6766 29.9433 34.6238 30.2014C37.3262 30.8843 38.7429 32.0399 38.8344 33.0749L38.8391 33.1815L39.5901 36.9888C36.3543 38.3389 32.5989 39.1464 28.5826 39.2309H27.1789C23.1717 39.1466 19.4242 38.3425 16.1934 36.998L16.2873 36.3541C16.4186 35.4854 16.573 34.5999 16.7316 33.9845C17.1569 32.3336 19.5496 31.1074 21.7512 30.1646C22.8907 29.6764 23.1375 29.3835 24.2842 28.884C24.3325 28.656 24.3591 28.4244 24.3638 28.1919L24.3612 27.9593L25.3364 27.8441L25.3489 27.8578C25.3754 27.8715 25.4218 27.7921 25.2589 26.7124L25.2019 26.692C24.9764 26.5984 24.156 26.13 24.1122 24.2579L24.0509 24.272C23.8687 24.303 23.3369 24.3106 23.2487 23.3711L23.2386 23.2148C23.2051 22.3624 22.5612 21.617 23.3893 20.9935L23.5116 20.9092L22.9972 19.5438L22.9709 19.2023C22.8993 18.0413 22.825 14.3374 24.8275 14.6978Z" fill="white"/></svg>`,
	};

	const MENU_PADDING = 23;
	const HEADER_HEIGHT = 28;
	const HEADER_MARGIN = 12;
	const ITEM_HEIGHT = 54;
	const SEPARATOR_HEIGHT = 1;
	const SEPARATOR_MARGIN = 6;


	class CallMenu
	{
		constructor(config = {})
		{
			this.eventEmitter = new JNEventEmitter();
			this.items = config.items || [];
			this.header = config.header || null;
			this.largeIcons = config.largeIcons === true;

			this.widget = null;
			this.menuLayout = null;

			this.callbacks = {
				onClose: typeof (config.onClose) === "function" ? config.onClose : DoNothing,
				onDestroy: typeof (config.onDestroy) === "function" ? config.onDestroy : DoNothing,
			}
		}

		calcMediumHeight()
		{
			let result = MENU_PADDING;
			result += this.items
				.map(item => item.separator ? SEPARATOR_MARGIN * 2 + SEPARATOR_HEIGHT : ITEM_HEIGHT)
				.reduce((a, b) => a + b);

			if (this.header)
			{
				result += HEADER_HEIGHT + HEADER_MARGIN;
			}
			return result;
		}

		show()
		{
			return new Promise((resolve, reject) =>
			{
				if (this.widget)
				{
					return resolve();
				}

				PageManager.openWidget(
					"layout",
					{
						backdrop: {
							hideNavigationBar: true,
							mediumPositionHeight: this.calcMediumHeight(),
							swipeAllowed: false // workaround for a ScrollView to work
						},
						//modal: false,
						onReady: layoutWidget =>
						{
							this.widget = layoutWidget;
							this.menuLayout = new MenuLayout({
								items: this.items,
								header: this.header,
								largeIcons: this.largeIcons,
							});
							this.widget.showComponent(this.menuLayout);
							this.widget.setListener(this.onLayoutWidgetEvent.bind(this));
							this.shown = true;

							resolve()
						},
						onError: error => reject(error),
					});
			})
		}

		close()
		{
			return new Promise((resolve, reject) =>
			{
				if (!this.widget)
				{
					return resolve();
				}

				this.widget.close(() =>
				{
					this.widget = null;
					resolve()
				})
			})
		}

		destroy()
		{
			if (this.widget)
			{
				this.widget.close(() => this.widget = null);
			}
			if (this.menuLayout)
			{
				this.menuLayout.destroy();
				this.menuLayout = null;
			}
			this.callbacks.onDestroy();
		}

		onLayoutWidgetEvent(eventName)
		{
			if (eventName === "onViewRemoved")
			{
				this.widget = null;
				this.callbacks.onClose(this)
			}
		}
	}

	class MenuLayout extends LayoutComponent
	{
		constructor(props = {})
		{
			super(props);

			this.state = {
				items: props.items || [],
				header: props.header || null,
				largeIcons: props.largeIcons === true,
			}
		}

		render()
		{
			return View(
				{
					style: {
						backgroundColor: "#FFFFFF",
						paddingTop: MENU_PADDING,
						flex: 1,
						paddingLeft: device.screen.safeArea.left,
						paddingRight: device.screen.safeArea.right,
						marginBottom: device.screen.safeArea.bottom,
					},
				},
				this.renderHeader(),
				ScrollView(
					{
						style: {
							flex: 1,
						}
					},
					View(
						{
							style: {flex: 1}
						},
						...this.state.items.map(item => item.separator ? this.separator() : this.menuItem(item))
					)
				)
			)
		}

		renderHeader()
		{
			if (!this.state.header)
			{
				return null
			}

			const text = typeof (this.state.header) === "object" ? this.state.header.text : this.state.header;
			const textColor = typeof (this.state.header) === "object" && "color" in this.state.header ? this.state.header.color : "#333333";

			return View(
				{
					style: {
						height: HEADER_HEIGHT,
						justifyContent: "center",
						marginBottom: HEADER_MARGIN,
						marginLeft: 20,
					}
				},
				Text({
					style: {
						height: 21,
						fontSize: 18,
						fontWeight: "bold",
						color: textColor
					},
					text: text
				})
			)
		}

		menuItem(config = {})
		{
			if (!config.text && !config.userModel)
			{
				return null;
			}
			let showSubMenu = config.showSubMenu === true;
			let imageSource = {};
			const showMuted = "userModel" in config && !config.userModel.microphoneState;
			const showCameraState = "userModel" in config && !config.userModel.cameraState;
			const iconIsAvatar = "userModel" in config;
			if ("userModel" in config)
			{
				if (config.userModel.avatar)
				{
					imageSource.uri = encodeURI(config.userModel.avatar);
				}
				else
				{
					imageSource.svg = {content: Icons.emptyAvatar};
				}
			}
			else if ("iconClass" in config && config.iconClass in Icons)
			{
				imageSource.svg = {content: Icons[config.iconClass]};
			}
			const selected = config.selected === true;

			return View(
				{
					style: {
						flexDirection: "row",
						alignItems: "center",
						//justifyContent: "center",
						height: ITEM_HEIGHT,
						// borderWidth: 1,
						// borderColor: "#aaaa00",
					},
					onClick: (typeof config.onClick) == "function" ? config.onClick : function ()
					{
					}
				},
				selected && View({
					style: {
						position: "absolute",
						height: "100%",
						width: "100%",
						flexGrow: 1,
						marginLeft: 16,
						marginRight: 16,
						backgroundColor: "#E6F8FE"
					}
				}),
				View({
						style: {
							alignItems: "center",
							justifyContent: "center",
							width: 59
						}
					},
					Image({
							style: {
								width: !this.state.largeIcons && iconIsAvatar ? 23 : 34,
								height: !this.state.largeIcons && iconIsAvatar ? 23 : 34,
								borderRadius: iconIsAvatar ? (this.state.largeIcons ? 17 : 11.5) : 0,
							},
							resizeMode: iconIsAvatar ? "cover" : "center",
							...imageSource
						}
					),
				),

				showMuted && Image({
					style: {
						width: 18,
						height: 22,
						marginRight: 16,
					},
					svg: {content: Icons.muted}
				}),
				showCameraState && Image({
					style: {
						width: 23,
						height: 18,
						marginRight: 16,
					},
					svg: {content: Icons.cameraOff}
				}),
				Text({
					style: {
						height: 25,
						fontSize: 18,
						flexGrow: 1,
						color: config.color || "#333333"
					},
					text: "text" in config ? config.text : config.userModel.name
				}),
				selected && Image({
					style: {
						width: 19,
						height: 15,
						marginRight: 32,
					},
					svg: {content: Icons.selected}
				}),
				showSubMenu && Image({
					style: {
						width: 21,
						height: 5,
						marginRight: 16,
					},
					svg: {content: Icons.ellipsis}
				})
			);
		}

		separator()
		{
			return new View({
				style: {
					height: SEPARATOR_HEIGHT / 2,
					marginLeft: this.state.largeIcons ? 66 : 59,
					marginTop: SEPARATOR_MARGIN,
					marginBottom: SEPARATOR_MARGIN,
					backgroundColor: '#DBDDE0'
				},
			})
		}

		destroy()
		{

		}
	}

	window.CallMenu = CallMenu;
})();