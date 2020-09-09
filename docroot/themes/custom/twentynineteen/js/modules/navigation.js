const topMenuLinks = document.querySelectorAll('.menu-main__item > a');

/**
 * Adds a focus class to top level list items
 * @return {void}
 */
for (let i = 0; i < topMenuLinks.length; i++) {
  topMenuLinks[i].onfocus = () => {
    topMenuLinks[i].parentElement.classList.add('focus');
  }
}

const subMenu = document.querySelectorAll('.menu-submenu');

/**
 * Removes focus class to top level list item when blur off last submenu item
 * @return {void}
 */
for (let i = 0; i < subMenu.length; i++) {
  const subMenuLinks = subMenu[i].querySelectorAll('a');

  subMenuLinks[subMenuLinks.length - 1].onblur = () => {
    subMenuLinks[subMenuLinks.length - 1].parentElement.parentElement.parentElement.classList.remove('focus');
  }
}

// const mainMenu = document.querySelector('.menu-main');
//
// const lastTopMenuLink = topMenuLinks[topMenuLinks.length - 1];
//
/**
 * Closes the mobile menu when you exit the last link
 * @return {void}
 */
// if (mainMenu.lastElementChild.querySelector('.menu-submenu') === null ) {
//   // If the last menu item does not have a submenu
//   lastTopMenuLink.onblur = () => {
//     document.getElementById('show-menu').checked = false;
//   }
// } else {
//   // If the last menu item does have a submenu
//   const lastSubMenuLink = mainMenu.lastElementChild.querySelector('.menu-submenu');
//
//   lastSubMenuLink.lastElementChild.lastElementChild.onblur = () => {
//     document.getElementById('show-menu').checked = false;
//   }
// }

const toggleButton = document.getElementsByClassName('show-menu');
const userMenu = document.querySelector('.menu--account');
const userMenuLinks = userMenu.getElementsByTagName('a');

/**
 * Closes the mobile menu when you exit the user menu
 * @return {void}
 */
userMenuLinks[userMenuLinks.length - 1].onblur = () => {
  toggleButton.checked = false;
  userMenu.classList.remove('menu--account--show');g
}

console.log(userMenu.getElementsByTagName('a')[userMenu.getElementsByTagName('a').length - 1 ]);

/**
 * Overrides "checkmark" behavior so that you can use the enter key to toggle the mobile menu.
 * @return {void}
 */
toggleButton.addEventListener("keyup", (event) => {
  event.preventDefault();
  if (event.keyCode === 13 || event.keyCode === 32) {
    if(toggleButton.checked === false) {
      toggleButton.checked = true;
      userMenu.classList.add('menu--account--show');
    } else {
      toggleButton.checked = false;
      userMenu.classList.remove('menu--account--show');
    }
  }
});

toggleButton.addEventListener("click", () => {
  if(toggleButton.checked === true) {
    userMenu.classList.add('menu--account--show');
  } else {
    userMenu.classList.remove('menu--account--show');
  }
});
