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


