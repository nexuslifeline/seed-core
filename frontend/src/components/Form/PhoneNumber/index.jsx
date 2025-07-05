/* eslint-disable react-hooks/exhaustive-deps */
import { forwardRef } from 'react';
import PropTypes from 'prop-types';
import Select from 'react-select';
import classNames from 'classnames';
import Styles from './Styles.module.scss';
import SharedStyles from '../shared.module.scss';
import SelectStyles from '../Select/Select.module.scss';
import FlagStyles from './Flags.module.scss';
import InvalidFeedback from '@components/InvalidFeedback';
import countries from '@shared/data/countries.json'; // Note! move in backend

const PhoneCountryOption = ({ data, innerRef, innerProps, isSelected }) => {
  const { dialCode, name, cca2 } = data;
  return (
    <div
      ref={innerRef}
      {...innerProps}
      className={classNames(Styles.optionItem, FlagStyles.f16, {
        [Styles.isSelected]: isSelected
      })}>
      <span
        className={classNames(
          FlagStyles.flag,
          FlagStyles?.[cca2?.toLowerCase()],
          Styles.flag
        )}
      />
      <span className={Styles.countryText}>{name}</span>
      <span className={Styles.dialCode}>{dialCode}</span>
    </div>
  );
};

const PhoneNumber = forwardRef(
  (
    {
      phoneCountry,
      phoneNumber,
      error,
      onPhoneCountryChange,
      onPhoneNumberChange,
      name = 'phoneNumber',
      label = 'Phone Number'
    },
    ref
  ) => {
    return (
      <div className={Styles.phoneNumberContainer}>
        <div className={classNames(Styles.countryPhoneNumber)}>
          <div
            className={classNames(
              SelectStyles.container,
              Styles.countryContainer
            )}>
            <Select
              className={classNames(
                SelectStyles.baseSelect,
                Styles.selectPhoneCountry
              )}
              value={phoneCountry}
              classNamePrefix='select'
              name='phoneCountry'
              placeholder='Code'
              getOptionLabel={({ dialCode }) => dialCode}
              getOptionRightLabel={({ label }) => label}
              getOptionValue={({ id }) => id}
              options={countries}
              onChange={onPhoneCountryChange}
              components={{ Option: PhoneCountryOption }}
            />
          </div>
          <input
            ref={ref}
            name={name}
            label={label}
            className={classNames(SharedStyles.input, Styles.fieldPhoneNumber)}
            value={phoneNumber}
            onChange={onPhoneNumberChange}
          />
        </div>
        {error && <InvalidFeedback error={error} />}
      </div>
    );
  }
);

PhoneNumber.propTypes = {
  onPhoneCountryChange: PropTypes.func,
  onPhoneNumberChange: PropTypes.func,
  onValidate: PropTypes.func,
  phoneCountry: PropTypes.object,
  phoneNumber: PropTypes.string,
  countries: PropTypes.array,
  error: PropTypes.string,
  label: PropTypes.string,
  name: PropTypes.string,
  getCountries: PropTypes.func,
  shouldValidate: PropTypes.bool
};

PhoneNumber.defaultProps = {
  shouldValidate: true
};

PhoneNumber.Instance = 'PhoneNumber';

export default PhoneNumber;
