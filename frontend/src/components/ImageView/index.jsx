import Styles from './ImageView.module.scss';
import Text from '@components/Text';

const ImageView = ({ img: Img, title, description }) => {
  return (
    <div className={Styles.container}>
      <Img className={Styles.img} />
      {title && <Text textAlign='center'>{title}</Text>}
      {description && (
        <Text variant='description' textAlign='center'>
          {description}
        </Text>
      )}
    </div>
  );
};

export default ImageView;
