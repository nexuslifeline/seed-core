/* eslint-disable react-hooks/exhaustive-deps */
import React, { useCallback, useEffect, useState, forwardRef } from 'react';
import PropTypes from 'prop-types';
import Styles from './PasswordInput.module.scss';
import classNames from 'classnames';
import debounce from 'lodash/debounce';
import StrengthBar from './StrengthBar';
import IconHidePassword from '@components/Icons/HidePassword';
import IconShowPassword from '@components/Icons/ShowPassword';
import InvalidFeedback from '@components/InvalidFeedback';

const strengths = {
  STRONG: 'strong',
  MEDIUM: 'medium',
  WEAK: 'weak',
  VERY_WEAK: 'veryWeak'
};

const score = {
  strong: 100,
  medium: 80,
  weak: 40,
  veryWeak: 20
};

const noCapital =
  '(?=.*[a-z])(?=.*[0-9])(?=.*[^a-zA-Z0-9])(?=.{8,})|(?=.*[a-z])(?=.*[0-9])(?=.*[^a-zA-Z0-9])(?=.{6,})';
const noDigit =
  '((?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?=.{8,}))|(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?=.{6,})';
const minSix = '((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9])(?=.{6,}))';
const noSpecialChar =
  '((?=.*[a-z])(?=.*[A-Z])(?=.{8,}))|(?=.*[a-z])(?=.*[A-Z])(?=.{6,})';

//a-z = has 1 lowercase | A-Z = has 1 uppercase | 0-9 = has 1 digit | ^a-zA-Z0-9 = has 1 special char | {8,} = atleast 8 char
const strongPassword = new RegExp(
  '(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9])(?=.{8,})'
);

//medium strength if 6 char or below length or no digit, or no capital char
const mediumPassword = new RegExp(
  `${minSix}|${noDigit}|${noCapital}|${noSpecialChar}`
);

const PasswordInput = forwardRef(
  (
    {
      label,
      error,
      containerClassName,
      showStrength,
      hideLabel = true,
      ...props
    },
    ref
  ) => {
    const [strength, setStrength] = useState('');
    const [showPassword, setShowPassword] = useState(false);

    const checkPassword = (value) => {
      if (!value) {
        setStrength('');
        return;
      }

      if (value.length <= 3) {
        setStrength(strengths.VERY_WEAK);
        return;
      }

      if (strongPassword.test(value)) {
        setStrength(strengths.STRONG);
      } else if (mediumPassword.test(value)) {
        setStrength(strengths.MEDIUM);
      } else {
        setStrength(strengths.WEAK);
      }
    };

    const debounceCheckPassword = useCallback(debounce(checkPassword, 200), []);

    const toggleShowPassword = () => {
      setShowPassword(!showPassword);
    };

    useEffect(() => {
      if (showStrength) {
        debounceCheckPassword(props?.value);
      }
    }, [props.value, showStrength]);

    return (
      <div className={classNames(Styles.container, containerClassName)}>
        <div className={Styles.searchContainer}>
          <input
            ref={ref}
            type={showPassword ? 'text' : 'password'}
            className={Styles.input}
            {...props}
          />
          {!hideLabel && <label className={Styles.label}>{label}</label>}
          {showStrength && (
            <StrengthBar {...{ strength, size: score[strength] }} />
          )}
          <div className={Styles.iconContainer}>
            {(showPassword && (
              <IconHidePassword
                className={Styles.showHideIcon}
                onClick={toggleShowPassword}
              />
            )) || (
              <IconShowPassword
                className={Styles.showHideIcon}
                onClick={toggleShowPassword}
              />
            )}
          </div>
        </div>
        {error && <InvalidFeedback error={error} />}
      </div>
    );
  }
);

PasswordInput.strengths = strengths;

PasswordInput.propTypes = {
  label: PropTypes.string,
  error: PropTypes.string,
  containerClassName: PropTypes.string,
  showStrength: PropTypes.bool
};

PasswordInput.Instance = 'PasswordInput';

export default PasswordInput;
