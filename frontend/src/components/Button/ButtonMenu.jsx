import React, { Fragment, forwardRef } from 'react';
import PropTypes from 'prop-types';
import Styles from './Button.module.scss';
import classNames from 'classnames';
import Content from './common/Content';
import { Menu, Transition } from '@headlessui/react';
import { variants, variantClasses } from './common/contants';
import ChevronDown from '@components/Icons/ChevronDown';

const ButtonMenu = forwardRef(
  ({ moreActions, icon, iconPlacement, label, variant, block, classsName, children }, ref) => {
    return (
      <Menu ref={ref} as='div' className={Styles.menu}>
        <Menu.Button
          className={classNames(Styles.button, variantClasses[variant], classsName, { [Styles.block]: block })}>
          {children || <Content icon={icon} iconPlacement={iconPlacement} label={label} />}
        </Menu.Button>
        <Transition
          as={Fragment}
          enter={Styles.transitionEnter}
          enterFrom={Styles.enterFrom}
          enterTo={Styles.enterTo}
          leave={Styles.transitionLeave}
          leaveFrom={Styles.leaveFrom}
          leaveTo={Styles.leaveTo}>
          <Menu.Items className={Styles.menuItems}>
            {moreActions.map(({ label, icon, children, ...props }, index) => (
              <Menu.Item key={index} className={Styles.menuItem} {...props}>
                <div>{children || <Content icon={icon} label={label} />}</div>
              </Menu.Item>
            ))}
          </Menu.Items>
        </Transition>
      </Menu>
    );
  }
);

ButtonMenu.Variants = variants;

ButtonMenu.propTypes = {
  label: PropTypes.string,
  isBlock: PropTypes.bool,
  block: PropTypes.bool,
  moreActions: PropTypes.array,
  icon: PropTypes.any,
};

ButtonMenu.defaultProps = {
  label: 'Button',
  variant: ButtonMenu.Variants.PRIMARY,
  block: false,
  icon: <ChevronDown />,
};

export default ButtonMenu;
