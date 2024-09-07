function NotifError(messsage, size = "mini", position = "top center") {
  return Lobibox.notify("error", {
    pauseDelayOnHover: true,
    rounded: true,
    continueDelayOnInactiveTab: false,
    position: position,
    icon: "bx bx-x-circle",
    msg: messsage,
    size: size,
    sound: false,
  });
}

function NotifSuccess(messsage, size = "mini", position = "top center") {
  return Lobibox.notify("success", {
    pauseDelayOnHover: true,
    rounded: true,
    continueDelayOnInactiveTab: false,
    position: position,
    icon: "bx bx-check-circle",
    msg: messsage,
    size: size,
    sound: false,
  });
}
