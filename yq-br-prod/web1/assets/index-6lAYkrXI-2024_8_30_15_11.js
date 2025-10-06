import { r as reactExports, q as useUserInfoStore, K as jsxRuntimeExports, S as trans, br as inputPwdStrLengthTest, bs as postMemberPasswordUpdate, a7 as Message, R as Image, P as joinClass, bt as getMemberAvatarUpdate, bu as postMemberBindEmail, x as useNavigate, aT as countryCode, bv as postMemberUpdate } from "./index-a_Ow1xUN-2024_8_30_15_11.js";
import { q as Form, r as PopCloseIcon, s as Input, t as PasswordFullIcon, B as Button, M as Modal, p as customFormatTimer, v as Picker, U as UserFullIcon, w as PixAccountIcon, x as PhoneIcon } from "./App-D9NLPZJN-2024_8_30_15_11.js";
import { EmailIcon } from "./Email-gUjxgRhU-2024_8_30_15_11.js";
const svg_theme_fill_color$3 = "_svg_theme_fill_color_jr3id_3";
const infoContent = "_infoContent_jr3id_55";
const headerInfo = "_headerInfo_jr3id_64";
const img$1 = "_img_jr3id_70";
const textTop = "_textTop_jr3id_151";
const container = "_container_jr3id_154";
const name = "_name_jr3id_256";
const nameGray = "_nameGray_jr3id_298";
const rightBtn = "_rightBtn_jr3id_349";
const bg = "_bg_jr3id_420";
const birthText = "_birthText_jr3id_638";
const btnContainer = "_btnContainer_jr3id_679";
const submitButton = "_submitButton_jr3id_687";
const submitBtn = "_submitBtn_jr3id_690";
const btnRetornar = "_btnRetornar_jr3id_694";
const birthContainer = "_birthContainer_jr3id_770";
const prefix = "_prefix_jr3id_785";
const formList = "_formList_jr3id_790";
const iconSize$1 = "_iconSize_jr3id_794";
const input = "_input_jr3id_807";
const css$3 = {
  svg_theme_fill_color: svg_theme_fill_color$3,
  infoContent,
  headerInfo,
  img: img$1,
  textTop,
  container,
  name,
  nameGray,
  rightBtn,
  bg,
  birthText,
  btnContainer,
  submitButton,
  submitBtn,
  btnRetornar,
  birthContainer,
  prefix,
  formList,
  iconSize: iconSize$1,
  input
};
const svg_theme_fill_color$2 = "_svg_theme_fill_color_o9enn_3";
const password = "_password_o9enn_55";
const title$2 = "_title_o9enn_128";
const tips = "_tips_o9enn_164";
const img1$2 = "_img1_o9enn_236";
const empty$2 = "_empty_o9enn_239";
const empty1$2 = "_empty1_o9enn_242";
const close$2 = "_close_o9enn_245";
const eight$2 = "_eight_o9enn_257";
const iconSize = "_iconSize_o9enn_261";
const css$2 = {
  svg_theme_fill_color: svg_theme_fill_color$2,
  password,
  title: title$2,
  tips,
  img1: img1$2,
  empty: empty$2,
  empty1: empty1$2,
  close: close$2,
  eight: eight$2,
  iconSize
};
const LoginPassword = ({ onClose }) => {
  reactExports.useState("");
  useUserInfoStore();
  const [form] = Form.useForm();
  const close2 = () => {
    onClose && onClose();
  };
  const submit = async (values) => {
    const [, err] = await postMemberPasswordUpdate({
      ty: 1,
      old_password: values.old_password,
      password: values.password
    });
    if (err) {
      return;
    }
    Message.success(trans("修改成功"));
    close2();
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs(
    "div",
    {
      className: css$2.password,
      onClick: () => {
        close2();
      },
      children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(PopCloseIcon, { className: css$2.close, onClick: onClose }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "div",
          {
            onClick: (e) => {
              e.stopPropagation();
            },
            children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css$2.title, children: trans("登录密码") }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css$2.tips, children: trans("保持定期更改密码的习惯，您的账户会更安全") }),
              /* @__PURE__ */ jsxRuntimeExports.jsxs(
                Form,
                {
                  form,
                  size: "small",
                  initialValues: {
                    old_password: "",
                    password: "",
                    confirmPassword: ""
                  },
                  onFinish: (values) => {
                    submit(values);
                  },
                  children: [
                    /* @__PURE__ */ jsxRuntimeExports.jsx(
                      Form.Field,
                      {
                        name: "old_password",
                        rules: [
                          { required: true, message: trans("请输入密码") },
                          {
                            pattern: inputPwdStrLengthTest,
                            message: trans("必须是6-20个英文字母和数字的组合")
                          }
                        ],
                        children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                          Input,
                          {
                            placeholder: "".concat(trans("请输入密码")),
                            noBg: true,
                            clearable: true,
                            type: "password",
                            prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(PasswordFullIcon, { className: css$2.iconSize })
                          }
                        )
                      }
                    ),
                    /* @__PURE__ */ jsxRuntimeExports.jsx(
                      Form.Field,
                      {
                        name: "password",
                        rules: [
                          { required: true, message: trans("请输入新密码") },
                          {
                            pattern: inputPwdStrLengthTest,
                            message: trans("必须是6-20个英文字母和数字的组合")
                          }
                        ],
                        children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                          Input,
                          {
                            type: "password",
                            clearable: true,
                            placeholder: "".concat(trans("请输入新密码")),
                            noBg: true,
                            prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(PasswordFullIcon, { className: css$2.iconSize })
                          }
                        )
                      }
                    ),
                    /* @__PURE__ */ jsxRuntimeExports.jsx(
                      Form.Field,
                      {
                        name: "confirmPassword",
                        rules: [
                          { required: true, message: trans("请重新输入新密码") },
                          {
                            pattern: inputPwdStrLengthTest,
                            message: trans("必须是6-20个英文字母和数字的组合")
                          },
                          {
                            validator: (rule, value2, callback) => {
                              if (value2 && value2 !== form.getFieldValue("password")) {
                                callback(trans("请重新输入新密码"));
                              } else {
                                callback();
                              }
                            }
                          }
                        ],
                        children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                          Input,
                          {
                            type: "password",
                            clearable: true,
                            placeholder: "".concat(trans("请重新输入新密码")),
                            noBg: true,
                            prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(PasswordFullIcon, { className: css$2.iconSize })
                          }
                        )
                      }
                    ),
                    /* @__PURE__ */ jsxRuntimeExports.jsx(Form.Field, { children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                      Button,
                      {
                        block: true,
                        onClick: () => {
                          form.submit();
                        },
                        children: trans("确认")
                      }
                    ) })
                  ]
                }
              )
            ]
          }
        )
      ]
    }
  );
};
const svg_theme_fill_color$1 = "_svg_theme_fill_color_1xfiu_3";
const avatar = "_avatar_1xfiu_55";
const title$1 = "_title_1xfiu_131";
const img1$1 = "_img1_1xfiu_170";
const empty$1 = "_empty_1xfiu_173";
const empty1$1 = "_empty1_1xfiu_176";
const close$1 = "_close_1xfiu_179";
const eight$1 = "_eight_1xfiu_191";
const btn$1 = "_btn_1xfiu_194";
const avatarContainer = "_avatarContainer_1xfiu_197";
const img = "_img_1xfiu_170";
const active = "_active_1xfiu_218";
const none = "_none_1xfiu_278";
const checkd = "_checkd_1xfiu_281";
const css$1 = {
  svg_theme_fill_color: svg_theme_fill_color$1,
  avatar,
  title: title$1,
  img1: img1$1,
  empty: empty$1,
  empty1: empty1$1,
  close: close$1,
  eight: eight$1,
  btn: btn$1,
  avatarContainer,
  img,
  active,
  none,
  checkd
};
const checkMaps = {
  black: "/home/icons/checkd.webp",
  blue: "/home/icons/checkd_blue.webp",
  purple: "/home/icons/checkd_purple.webp",
  whiteRed: "/home/icons/checkd_white_red.webp",
  versaceYellow: "/home/icons/checkd_versaceYellow.webp",
  lancomePeach: "/home/icons/checkd_lancomePeach.webp",
  hermesOrange: "/home/icons/checkd_hermesOrange.webp",
  whiteBlue: "/home/icons/checkd_whiteBlue.webp",
  sk2: "/home/icons/checkd_sk2.webp",
  whiteYellow: "/home/icons/checkd_whiteYellow.webp",
  lightBrown: "/home/icons/checkd_lightBrown.webp",
  whiteOrange: "/home/icons/checkd_whiteOrange.webp",
  furlaBlue: "/home/icons/checkd_furlaBlue.webp",
  whitePink: "/home/icons/check_whitePink.webp",
  bvGreen: "/home/icons/check_bvGreen.webp",
  whiteBrown: "/home/icons/check_whiteBrown.webp",
  AnnaSuiPurple: "/home/icons/check_AnnaSuiPurple.webp",
  whitePurple: "/home/icons/check_whitePurple.webp",
  burgundyRed: "/home/icons/check_burgundyRed.webp",
  whiteDarkGreen: "/home/icons/check_whiteDarkGreen.webp",
  greenGold: "/home/icons/checkd_greenGold.webp"
};
const avatarList = [
  1,
  2,
  3,
  4,
  5,
  6,
  7,
  8,
  9,
  10,
  11,
  12,
  13,
  14,
  15,
  16,
  17,
  18,
  19,
  20
];
const Avatar = (props) => {
  const { theme } = useUserInfoStore();
  const [checked, setChecked] = reactExports.useState(props.defaultValue);
  reactExports.useEffect(() => {
    setChecked(props.defaultValue - 1);
  }, [props.defaultValue]);
  const onClose = () => {
    props.onClose && props.onClose();
  };
  const submit = async (params) => {
    console.error("checked", checked);
    const [res, err] = await getMemberAvatarUpdate({ id: checked + 1 });
    if (!err) {
      Message.success(trans("修改成功"));
      props.onClose && props.onClose();
    }
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$1.avatar, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(PopCloseIcon, { className: css$1.close, onClick: onClose }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        onClick: (e) => {
          e.stopPropagation();
        },
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css$1.title, children: trans("更换头像") }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.avatarContainer, children: avatarList.map((item, index) => /* @__PURE__ */ jsxRuntimeExports.jsxs(
            "div",
            {
              className: checked == index ? css$1.active : "",
              onClick: (e) => {
                e.stopPropagation();
                setChecked(index);
              },
              children: [
                /* @__PURE__ */ jsxRuntimeExports.jsx(
                  Image,
                  {
                    className: css$1.img,
                    src: "/home/avatar/avatar".concat(index + 1, ".webp")
                  }
                ),
                /* @__PURE__ */ jsxRuntimeExports.jsx(
                  Image,
                  {
                    className: joinClass(
                      css$1.checkd,
                      checked == index ? "" : css$1.none
                    ),
                    src: checkMaps[theme] || "/home/icons/checkd.webp"
                  }
                )
              ]
            },
            index
          )) }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$1.btn, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
            Button,
            {
              block: true,
              onClick: () => {
                submit();
              },
              children: trans("保存")
            }
          ) })
        ]
      }
    )
  ] });
};
const svg_theme_fill_color = "_svg_theme_fill_color_1invu_3";
const email = "_email_1invu_55";
const title = "_title_1invu_128";
const img1 = "_img1_1invu_167";
const empty = "_empty_1invu_176";
const empty1 = "_empty1_1invu_179";
const close = "_close_1invu_182";
const eight = "_eight_1invu_194";
const btn = "_btn_1invu_197";
const css = {
  svg_theme_fill_color,
  email,
  title,
  img1,
  empty,
  empty1,
  close,
  eight,
  btn
};
const Email = (props) => {
  var _a;
  const [form] = Form.useForm();
  useUserInfoStore();
  const onClose = () => {
    props.onClose && props.onClose();
  };
  const submit = async (params) => {
    if (props.defaultValue && params.email === props.defaultValue) {
      Message.error(trans("新邮箱不能与旧邮箱相同"));
      return;
    }
    const [res, err] = await postMemberBindEmail(params);
    if (err) {
      return;
    }
    Message.success(props.defaultValue ? trans("修改成功") : trans("绑定成功"));
    onClose();
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css.email, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(PopCloseIcon, { className: css.close, onClick: onClose }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        onClick: (e) => {
          e.stopPropagation();
        },
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css.title, children: trans("Email") }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs(
            Form,
            {
              form,
              size: "small",
              initialValues: {
                email: (_a = props.defaultValue) != null ? _a : ""
              },
              onFinish: (values) => {
                submit(values);
              },
              children: [
                /* @__PURE__ */ jsxRuntimeExports.jsx(
                  Form.Field,
                  {
                    name: "email",
                    rules: [
                      { required: true, message: trans("请输入邮箱地址") },
                      { type: "email", message: trans("请输入正确的电子邮件地址") }
                    ],
                    children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                      Input,
                      {
                        placeholder: "".concat(trans("请输入邮箱地址")),
                        noBg: true,
                        prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(EmailIcon, { className: css.img1 })
                      }
                    )
                  }
                ),
                /* @__PURE__ */ jsxRuntimeExports.jsx(Form.Field, { children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css.btn, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                  Button,
                  {
                    block: true,
                    onClick: () => {
                      form.submit();
                    },
                    children: trans("确认")
                  }
                ) }) })
              ]
            }
          )
        ]
      }
    )
  ] });
};
const monthList = [
  { label: "01", value: "01" },
  { label: "02", value: "02" },
  { label: "03", value: "03" },
  { label: "04", value: "04" },
  { label: "05", value: "05" },
  { label: "06", value: "06" },
  { label: "07", value: "07" },
  { label: "08", value: "08" },
  { label: "09", value: "09" },
  { label: "10", value: "10" },
  { label: "11", value: "11" },
  { label: "12", value: "12" }
];
const FormList = () => {
  const { info, getUserInfoByStore, theme } = useUserInfoStore();
  const [form] = Form.useForm();
  const [month, setMonth] = reactExports.useState("");
  const navigate = useNavigate();
  const submit = async (params) => {
    console.error(params);
    console.error(info.whatsapp);
    const birth = "".concat(params.year, "-").concat(params.month < 10 ? "0" + Number(params.month) : params.month, "-").concat(params.day < 10 ? "0" + Number(params.day) : params.day);
    const _params = {
      birth,
      whatsapp: params.whatsapp,
      facebook: params.facebook,
      telegram: params.telegram,
      twitter: params.twitter
    };
    if (!params.year) {
      delete _params.birth;
    }
    if ((info == null ? void 0 : info.whatsapp) == params.whatsapp && (info == null ? void 0 : info.facebook) == params.facebook && (info == null ? void 0 : info.telegram) == params.telegram && (info == null ? void 0 : info.twitter) == params.twitter && Number(customFormatTimer(info.birth, "DD")) == Number(params.day) && Number(customFormatTimer(info.birth, "MM")) == Number(params.month) && Number(customFormatTimer(info.birth, "YYYY")) == Number(params.year)) {
      Message.info(trans("Não efetuou quaisquer edições"));
      return;
    }
    const [res, err] = await postMemberUpdate(_params);
    if (err) {
      return;
    }
    Message.success(trans("Informações pessoais alteradas com sucesso"));
    getUserInfoByStore();
  };
  reactExports.useEffect(() => {
    if (info) {
      if (info == null ? void 0 : info.whatsapp) {
        form.setFieldsValue({
          whatsapp: info.whatsapp
        });
      }
      if (info == null ? void 0 : info.facebook) {
        form.setFieldsValue({
          facebook: info.facebook
        });
      }
      if (info == null ? void 0 : info.telegram) {
        form.setFieldsValue({
          telegram: info.telegram
        });
      }
      if (info == null ? void 0 : info.twitter) {
        form.setFieldsValue({
          twitter: info.twitter
        });
      }
      if ((info == null ? void 0 : info.birth) && (info == null ? void 0 : info.birth) != 0) {
        form.setFieldsValue({
          day: customFormatTimer(info.birth, "DD"),
          month: customFormatTimer(info.birth, "MM"),
          year: customFormatTimer(info.birth, "YYYY")
        });
      } else {
        form.setFieldsValue({
          day: customFormatTimer(""),
          month: customFormatTimer(""),
          year: customFormatTimer("")
        });
      }
    }
  }, [info]);
  const isSetBirth = (() => {
    if (info) {
      return (info == null ? void 0 : info.birth) && (info == null ? void 0 : info.birth) != "0";
    }
    return false;
  })();
  return /* @__PURE__ */ jsxRuntimeExports.jsxs(
    Form,
    {
      form,
      size: "small",
      initialValues: {
        whatsapp: "",
        facebook: "",
        telegram: "",
        twitter: "",
        day: "",
        month: "",
        year: ""
      },
      onFinish: (values) => {
        submit(values);
      },
      children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          Form.Field,
          {
            name: "whatsapp",
            rules: [
              // { required: true, message: '输入6-40个数字' },
              {
                pattern: /^[0-9]{6,40}$/,
                message: trans("输入6-40个数字")
              }
            ],
            children: /* @__PURE__ */ jsxRuntimeExports.jsx(
              Input,
              {
                className: css$3.input,
                type: "text",
                clearable: true,
                placeholder: trans("请输入WhatsApp"),
                prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$3.prefix, src: "/home/icons/whatsapp.webp" })
              }
            )
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          Form.Field,
          {
            name: "facebook",
            rules: [
              // { required: true, message: `Apenas é permitido introduzir letras, números e caracteres especiais  ${'@._-\ '}` },
              {
                pattern: /^[\w@._-]{6,40}$/,
                message: "".concat(trans("输入6-40 只能输入字母、数字和特殊字符"), " ").concat("@._- ")
              }
            ],
            children: /* @__PURE__ */ jsxRuntimeExports.jsx(
              Input,
              {
                type: "text",
                className: css$3.input,
                clearable: true,
                placeholder: trans("请输入您的脸书账号"),
                prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$3.prefix, src: "/home/icons/facebook.webp" })
              }
            )
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          Form.Field,
          {
            name: "telegram",
            rules: [
              // { required: true, message: 'Introduza 5-40 letras/números/sublinhados' },
              {
                pattern: /^[0-90-9A-Za-z]{6,40}$/,
                message: trans("输入6-40个字母/数字/下划线")
              }
            ],
            children: /* @__PURE__ */ jsxRuntimeExports.jsx(
              Input,
              {
                type: "text",
                className: css$3.input,
                clearable: true,
                placeholder: trans("请输入您的 Telegram 用户名"),
                prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$3.prefix, src: "/home/icons/telegram.webp" })
              }
            )
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          Form.Field,
          {
            name: "twitter",
            rules: [
              // { required: true, message: 'Introduza 4-40 letras/números/símbolos' },
              {
                pattern: /^[0-9A-Za-z]{6,40}$/,
                message: trans("输入6-40个字母/数字/符号")
              }
            ],
            children: /* @__PURE__ */ jsxRuntimeExports.jsx(
              Input,
              {
                type: "text",
                className: css$3.input,
                clearable: true,
                placeholder: trans("输入推特账号"),
                prefix: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { className: css$3.prefix, src: "/home/icons/twitter.webp" })
              }
            )
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: css$3.birthText, children: trans("选择出生日期（一旦设置，无法修改）") }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.birthContainer, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            Form.Field,
            {
              name: "day",
              rules: [
                // { required: true, message: '请输入' },
                {
                  pattern: /^((0?[1-9])|([1-2][0-9])|30|31)$/,
                  message: trans("请输入正确日期")
                }
              ],
              children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                Input,
                {
                  type: "text",
                  clearable: true,
                  radius: true,
                  disabled: isSetBirth,
                  className: joinClass(css$3.inputHeight, css$3.input),
                  placeholder: trans("天")
                }
              )
            }
          ),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            Form.Field,
            {
              name: "month",
              rules: [
                // { required: true, message: '请选择' }
              ],
              children: info && /* @__PURE__ */ jsxRuntimeExports.jsx(
                Picker,
                {
                  label: "",
                  defaultValue: customFormatTimer(info.birth, "MM"),
                  items: monthList,
                  placeholder: trans("月"),
                  disabled: isSetBirth,
                  newPickerBg: true,
                  onChange: (_value) => {
                    setMonth(_value);
                  }
                },
                info.birth
              )
            }
          ),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            Form.Field,
            {
              name: "year",
              rules: [
                // { required: true, message: '请输入出生年份' },
                {
                  pattern: /^(1949|19[5-9]\d|20\d{2}|2006)$/,
                  message: trans("生日日期格式错误")
                }
              ],
              children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                Input,
                {
                  type: "text",
                  clearable: true,
                  radius: true,
                  disabled: isSetBirth,
                  className: joinClass(css$3.inputHeight, css$3.input),
                  placeholder: trans("年")
                }
              )
            }
          )
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(Form.Field, { children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.btnContainer, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: /* @__PURE__ */ jsxRuntimeExports.jsx(
            Button,
            {
              className: joinClass(css$3.submitButton, css$3.btnRetornar),
              block: true,
              onClick: () => {
                navigate(-1);
              },
              type: "borderBtn",
              children: trans("返回")
            }
          ) }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { children: /* @__PURE__ */ jsxRuntimeExports.jsx(
            Button,
            {
              className: joinClass(css$3.submitButton, css$3.submitBtn),
              block: true,
              onClick: () => {
                form.submit();
              },
              children: trans("保存")
            }
          ) })
        ] }) })
      ]
    }
  );
};
const InputItem = () => {
  const { info, getUserInfoByStore, theme } = useUserInfoStore();
  const { isSetWithdrawPassword } = useUserInfoStore();
  const navigate = useNavigate();
  const [loginPwdStatus, setLoginPwdStatus] = reactExports.useState(false);
  const [emailStatus, setEmailStatus] = reactExports.useState(false);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.formList, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css$3.textTop, css$3.bg), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(UserFullIcon, { className: css$3.iconSize }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$3.name, children: info == null ? void 0 : info.username })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css$3.textTop, css$3.bg), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(PixAccountIcon, { className: css$3.iconSize }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: css$3.name, children: info == null ? void 0 : info.uid })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css$3.container, css$3.textTop), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(PhoneIcon, { className: css$3.iconSize }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: (info == null ? void 0 : info.phone) ? css$3.name : css$3.nameGray, children: (info == null ? void 0 : info.phone) ? "".concat(countryCode, "-").concat(info == null ? void 0 : info.phone) : trans("链接您的手机") }),
      (info == null ? void 0 : info.phone) ? null : /* @__PURE__ */ jsxRuntimeExports.jsx(
        "span",
        {
          className: css$3.rightBtn,
          onClick: () => {
            navigate("/enter-login-psw");
          },
          children: trans("转到链接")
        }
      )
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        className: joinClass(css$3.container, css$3.textTop),
        onClick: (e) => {
          if (isSetWithdrawPassword) {
            return;
          } else {
            navigate("/withdraw-set?to=withdraw");
          }
        },
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(PasswordFullIcon, { className: css$3.iconSize }),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            "span",
            {
              className: (info == null ? void 0 : info.withdraw_pwd) == 0 || (info == null ? void 0 : info.withdraw_pwd) == "" ? css$3.nameGray : css$3.name,
              children: (info == null ? void 0 : info.withdraw_pwd) == 0 || (info == null ? void 0 : info.withdraw_pwd) == "" ? trans("提现密码") : "******"
            }
          )
        ]
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsxs(
      "div",
      {
        className: joinClass(css$3.container, css$3.textTop),
        onClick: (e) => {
          setLoginPwdStatus(true);
        },
        children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(PasswordFullIcon, { className: css$3.iconSize }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: (info == null ? void 0 : info.password) == "" ? css$3.nameGray : css$3.name, children: (info == null ? void 0 : info.password) == "" ? "" : "******" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            "span",
            {
              className: css$3.rightBtn,
              onClick: (e) => {
                setLoginPwdStatus(true);
              },
              children: trans("修改")
            }
          )
        ]
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: joinClass(css$3.container, css$3.textTop), children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(EmailIcon, { className: css$3.iconSize }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: (info == null ? void 0 : info.email) ? css$3.name : css$3.nameGray, children: (info == null ? void 0 : info.email) ? info == null ? void 0 : info.email : trans("Email") }),
      (info == null ? void 0 : info.email) ? null : /* @__PURE__ */ jsxRuntimeExports.jsx(
        "span",
        {
          className: css$3.rightBtn,
          onClick: (e) => {
            e.stopPropagation();
            setEmailStatus(true);
          },
          children: trans("修改")
        }
      )
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Modal, { isOpen: loginPwdStatus, onClose: (e) => e && e.stopPropagation(), children: /* @__PURE__ */ jsxRuntimeExports.jsx(
      LoginPassword,
      {
        onClose: () => {
          setLoginPwdStatus(false);
          getUserInfoByStore();
        }
      }
    ) }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Modal, { isOpen: emailStatus, onClose: (e) => e && e.stopPropagation(), children: /* @__PURE__ */ jsxRuntimeExports.jsx(
      Email,
      {
        defaultValue: info == null ? void 0 : info.email,
        onClose: () => {
          setEmailStatus(false);
          getUserInfoByStore();
        }
      }
    ) })
  ] });
};
const PersonalInformation = () => {
  const { info, getUserInfoByStore, theme } = useUserInfoStore();
  Form.useForm();
  const [avatarStatus, setAvatarStatus] = reactExports.useState(false);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.infoContent, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: css$3.headerInfo, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: css$3.img, children: /* @__PURE__ */ jsxRuntimeExports.jsx(Image, { src: "/home/avatar/avatar".concat(info == null ? void 0 : info.avatar, ".webp") }) }),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "p",
        {
          onClick: () => {
            setAvatarStatus(true);
          },
          children: trans("建立")
        }
      )
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx(InputItem, {}),
    /* @__PURE__ */ jsxRuntimeExports.jsx(FormList, {}),
    /* @__PURE__ */ jsxRuntimeExports.jsx(Modal, { isOpen: avatarStatus, onClose: (e) => e && e.stopPropagation(), children: /* @__PURE__ */ jsxRuntimeExports.jsx(
      Avatar,
      {
        defaultValue: info == null ? void 0 : info.avatar,
        onClose: () => {
          setAvatarStatus(false);
          getUserInfoByStore();
        }
      }
    ) })
  ] });
};
export {
  PersonalInformation as default
};
