import debounce from 'lodash/debounce';

import Text from '@components/Text';
import Button from '@components/Button';
import SearchInput from '@components/Form/SearchInput';

import Styles from './Container.module.scss';

const Container = ({
  children,
  title,
  description,
  buttonCaption,
  onSearch
}) => {
  const debouncedOnChange = debounce((e) => onSearch?.(e.target.value), 500);

  return (
    <div className={Styles.container}>
      <div className={Styles.header}>
        <div className={Styles.titleContainer}>
          <Text variant='title' size='xl'>
            {title}
          </Text>
          <Text variant='description'>{description}</Text>
        </div>
      </div>
      <div className={Styles.actionContainer}>
        <SearchInput onChange={debouncedOnChange} />
        <Button className={Styles.btn}>{buttonCaption}</Button>
      </div>
      <div className={Styles.body}>{children}</div>
    </div>
  );
};

export default Container;
