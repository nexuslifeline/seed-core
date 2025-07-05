import IconImage from '@components/Icons/Image';
import IconPDF from '@components/Icons/Pdf';
import IconDocument from '@components/Icons/Document';

const FileIconManager = ({ fileType, ...props }) => {
  const imageFileTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
  if (imageFileTypes.includes(fileType)) {
    return <IconImage {...props} />;
  } else if (fileType === 'application/pdf') {
    return <IconPDF {...props} />;
  } else {
    return <IconDocument {...props} />;
  }
};

export default FileIconManager;
