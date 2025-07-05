import React from 'react';
import PropTypes from 'prop-types';
import Styles from './Modal.module.scss';
import classNames from 'classnames';
import { Dialog, Transition } from '@headlessui/react';
import { Fragment } from 'react';

const sizeClasses = {
  sm: Styles.small,
  md: Styles.medium,
  lg: Styles.large,
  xl: Styles.extraLarge,
};

const sizes = {
  SMALL: 'sm',
  MEDIUM: 'md',
  LARGE: 'lg',
  EXTRA_LARGE: 'xl',
};

const Modal = ({ isOpen, title, content, children, onClose, size }) => {
  return (
    <Transition
      show={isOpen}
      enter={Styles.transitionEnter}
      enterFrom={Styles.enterFrom}
      enterTo={Styles.enterTo}
      leave={Styles.transitionLeave}
      leaveFrom={Styles.leaveFrom}
      leaveTo={Styles.leaveTo}
      as={Fragment}>
      <Dialog onClose={onClose} className={Styles.container}>
        <div className={Styles.backdrop}></div>
        <div className={Styles.panelContainer}>
          <Dialog.Panel className={classNames(Styles.panel, sizeClasses[size])}>
            {title && <Dialog.Title>{title}</Dialog.Title>}
            {content || children}
          </Dialog.Panel>
        </div>
      </Dialog>
    </Transition>
  );
};

Modal.Sizes = sizes;

Modal.propTypes = {
  isOpen: PropTypes.bool,
  title: PropTypes.string,
  content: PropTypes.any,
  children: PropTypes.node,
  onClose: PropTypes.func, //called when click on backdrop
  size: PropTypes.string,
};

Modal.defaultProps = {
  onClose: () => {},
  size: Modal.Sizes.SMALL,
};

export default Modal;
