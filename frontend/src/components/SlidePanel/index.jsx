import Styles from './SlidePanel.module.scss';
import Close from '@components/Actions/Panel/Close';
import classNames from 'classnames';
import { withLayoutState } from '@shared/context/LayoutState';

const SlidePanel = ({ isSlideOpen, setIsSlideOpen }) => {
  return (
    <div className={classNames(Styles.container, isSlideOpen && Styles.open)}>
      <div className={Styles.header}>
        <Close onClick={() => setIsSlideOpen(false)} />
      </div>
    </div>
  );
};

export default withLayoutState(SlidePanel);
