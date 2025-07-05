import classNames from 'classnames';
import React from 'react';
import { useDropzone } from 'react-dropzone';
import Styles from './FileUploader.module.scss';
import PropTypes from 'prop-types';
import IconCloudUpload from '@components/Icons/UploadToCloud';

const FileUploader = ({ description, children, ...props }) => {
  const { getRootProps, getInputProps } = useDropzone({ ...props });
  return (
    <div {...getRootProps({ className: classNames(Styles.container) })}>
      <input {...getInputProps()} />
      {children || (
        <>
          <IconCloudUpload className={Styles.icon} />
          <p className={Styles.description}>{description}</p>
        </>
      )}
    </div>
  );
};

FileUploader.propTypes = {
  description: PropTypes.string,
};

FileUploader.defaultProps = {
  description: `Drag n' drop some files here, or click to select files`,
};

export default FileUploader;
