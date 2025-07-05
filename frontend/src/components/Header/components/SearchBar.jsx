import SearchInput from '@components/Form/SearchInput';
import Styles from './SearchBar.module.scss';

const SearchBar = (props) => {
  return (
    <div className={Styles.container}>
      <SearchInput placeholder='Search' />
    </div>
  );
};

export default SearchBar;
