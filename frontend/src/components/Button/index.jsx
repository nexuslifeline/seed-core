import React, { forwardRef } from 'react';
import PropTypes from 'prop-types';
import Styles from './Button.module.scss';
import classNames from 'classnames';
import { variants, variantClasses } from './common/contants';

import Content from './common/Content';
import ButtonMenu from './ButtonMenu';
import Loader from '@components/Loader';

const Button = forwardRef(
  (
    {
      moreActions,
      icon,
      iconPlacement,
      label,
      variant,
      block,
      isBusy,
      className,
      children,
      type = 'button',
      ...props
    },
    ref
  ) => {
    if (moreActions?.length > 0) {
      return (
        <ButtonMenu
          ref={ref}
          {...{ moreActions, icon, iconPlacement, label, variant, block }}
        />
      );
    }

    return (
      <button
        ref={ref}
        className={classNames(
          Styles.button,
          variantClasses[variant],
          className,
          {
            [Styles.block]: block
          }
        )}
        {...props}>
        {isBusy && <Loader marginRight={'8px'} className={Styles.loader} />}
        {children || <Content {...{ icon, iconPlacement, label }} />}
      </button>
    );
  }
);

Button.Variants = variants;

Button.propTypes = {
  label: PropTypes.string,
  isBusy: PropTypes.bool,
  block: PropTypes.bool,
  moreActions: PropTypes.array,
  icon: PropTypes.any
};

Button.defaultProps = {
  label: 'Button',
  variant: Button.Variants.PRIMARY,
  block: false
};

export default Button;
