import { cloneElement } from 'react';
import { useForm } from 'react-hook-form';
import PropTypes from 'prop-types';

import TextArea from './TextArea';
import TextInput from './TextInput';
import Select from './Select';
import FieldGroup from './FieldGroup';
import PhoneNumber from './PhoneNumber';
import PasswordInput from './PasswordInput';
import Toggle from './Toggle';
import SearchInput from './SearchInput';
import { capitalize } from '@lib/utils';

const Form = ({ children, onSubmit, defaultValues = {} }) => {
  const {
    register,
    handleSubmit,
    setValue,
    clearErrors,
    formState: { errors }
  } = useForm({ defaultValues });

  // Refactored the makeFieldError function to improve readability and maintainability
  // Added comments to describe the purpose of the function and each error message

  const makeFieldError = ({
    fieldName,
    fieldLabel,
    minLength,
    maxLength,
    min,
    max,
    error
  }) => {
    const field = fieldLabel || fieldName; // Set the field label or field name if label is not provided
    // Return the appropriate error message based on the error type
    return (
      {
        required: error?.message || `${capitalize(field)} field is required.`,
        minLength:
          error?.message ||
          `The ${capitalize(
            field
          )} field must be at least ${minLength} characters long.`,
        maxLength:
          error?.message ||
          `The ${capitalize(
            field
          )} field must not exceed ${maxLength} characters in length.`,
        max: error?.message || `The ${field} field must not exceed ${max}.`,
        min: error?.message || `The ${field} field must be at least ${min}.`,
        pattern: `The ${field} field must match the expected pattern.`
      }?.[error?.type] || 'Please enter a valid value.' // Default error message if no specific error type is provided
    );
  };

  // This function creates props for a select component
  const createSelectProps = (child, name) => {
    return {
      // When the select value changes, update the form value using react-hook-form
      onChange: (option) => {
        setValue(name, option); // set value in form so that react-hook-form can validate
        clearErrors(name); // clear errors in react-hook-form
        child?.props?.onChange?.(option); // then call onChange on child
      }
    };
  };

  // This function creates an object with a single property onPhoneNumberChange, which is a function.
  // The onPhoneNumberChange function takes an event (e) as a parameter, updates the form value using setValue from react-hook-form,
  // clears any errors in the form using clearErrors from react-hook-form, and then calls the onPhoneNumberChange function on the child
  // component if it exists.
  const createPhoneNumberProps = (child, name) => {
    return {
      onPhoneNumberChange: (e) => {
        setValue(name, e.target.value); // set value in form so that react-hook-form can validate
        clearErrors(name); // clear errors in react-hook-form
        child?.props?.onPhoneNumberChange?.(e); // then call onPhoneNumberChange on child
      }
    };
  };

  const makeArrayChildren = (children) => {
    return Array.isArray(children) ? children : [children];
  };

  // This function injects props into a React component based on certain conditions
  const injectProps = (child, { key, ...restProps } = {}) => {
    if (
      ![
        'FieldGroup',
        'PhoneNumber',
        'Select',
        'Toggle',
        'PasswordInput',
        'SearchInput',
        'TextInput'
      ].includes(child?.type?.Instance)
    ) {
      console.log('child', child);
      return child;
    }

    // If the child component is an instance of FieldGroup, recursively call injectProps on its children
    if (child?.type?.Instance === 'FieldGroup') {
      const { children, label } = child?.props || {};
      return cloneElement(child, {
        key: child?.key || key,
        children: makeArrayChildren(children)?.map((c, cKey) =>
          injectProps(c, { key: `${key}-${cKey}`, label })
        )
      });
    }
    // Destructure props from the child component, defaulting to an empty object
    const { rule, name } = child.props || {};

    // Check if the rule object has any keys, set hasRule to true if it does
    const hasRule = Boolean(Object.keys(rule || {})?.length);
    // Spread the result of invoking the register function with name and rule as arguments into rcfProps
    const rcfProps = { key: child?.key || key, ...register(name, rule) };

    // If the rule object is empty, return the child component as is
    if (!hasRule) return cloneElement(child, { ...rcfProps });

    const label = child?.props?.label || restProps?.label;

    // Initialize mergedProps with the key from the child component or the provided key, and rcfProps
    let mergedProps = {
      ...rcfProps,
      ...restProps,
      label
    };

    // Check if errors exist for the field, and if so, add error props
    const hasErrors = Boolean(errors?.[name]);
    if (hasErrors) {
      const errorProps = {
        error: makeFieldError({
          fieldName: name,
          fieldLabel: label,
          error: errors?.[name],
          ...rule
        })
      };
      mergedProps = { ...mergedProps, ...errorProps };
    }

    // Check if the child component is an instance of Select, and if so, merge select props into mergedProps
    if (child?.type?.Instance === 'Select') {
      return cloneElement(child, {
        ...mergedProps,
        ...createSelectProps(child, name)
      });
    }

    // Check if the child component is an instance of PhoneNumber, and if so, merge phone number props into mergedProps
    if (child?.type?.Instance === 'PhoneNumber') {
      return cloneElement(child, {
        ...mergedProps,
        ...createPhoneNumberProps(child, name)
      });
    }

    // If none of the above conditions are met, simply clone the child component with mergedProps
    return cloneElement(child, mergedProps);
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      {makeArrayChildren(children)?.map((child, idx) =>
        injectProps(child, idx)
      )}
    </form>
  );
};

Form.Search = SearchInput;
Form.Toggle = Toggle;
Form.Password = PasswordInput;
Form.PhoneNumber = PhoneNumber;
Form.TextArea = TextArea;
Form.TextInput = TextInput;
Form.Select = Select;
Form.FieldGroup = FieldGroup;

Form.propTypes = {
  children: PropTypes.node
};

Form.Instance = 'Form';

export default Form;
