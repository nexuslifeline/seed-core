import { Fragment, memo } from 'react';
import classNames from 'classnames';
import { Menu, Transition } from '@headlessui/react';
import Styles from './Menu.module.scss';
import { snakeToCamel } from '@shared/lib/utils';

const BaseMenu = memo(({ style, className, children }) => {
  return (
    <Menu as='div' className={classNames(Styles.container, className)} style={style}>
      {children}
    </Menu>
  );
});

const Items = ({ children, className, direction = 'default', ...props }) => {
  return (
    <Transition
      as={Fragment}
      enter={Styles.transition}
      enterFrom={Styles.enterFrom}
      enterTo={Styles.enterTo}
      leave={Styles.transition}
      leaveFrom={Styles.enterTo}
      leaveTo={Styles.enterFrom}>
      <Menu.Items className={classNames(Styles.menuItems, Styles[snakeToCamel(direction)], className)} {...props}>
        {children}
      </Menu.Items>
    </Transition>
  );
};

const Button = ({ className, children, ...props }) => {
  return (
    <Menu.Button className={classNames(Styles.button, className)} {...props}>
      {children}
    </Menu.Button>
  );
};

BaseMenu.Button = memo(Button);
BaseMenu.Items = memo(Items);
BaseMenu.Item = memo(Menu.Item);

export default BaseMenu;
