import { registerBlockType } from "@wordpress/blocks";
import { MediaUpload, MediaUploadCheck } from "@wordpress/block-editor";
import { Button } from "@wordpress/components";

registerBlockType("wp-modular/gallery", {
  edit({ attributes, setAttributes }) {
    const { images } = attributes;

    return (
      <div className="gallery-block-editor">
        <MediaUploadCheck>
          <MediaUpload
            onSelect={(media) => setAttributes({ images: media })}
            allowedTypes={["image"]}
            multiple
            gallery
            value={images.map((img) => img.id)}
            render={({ open }) => (
              <Button onClick={open} isPrimary>
                Pilih Gambar
              </Button>
            )}
          />
        </MediaUploadCheck>
        <div className="preview">
          {images.map((img, i) => (
            <img
              key={i}
              src={img.url}
              style={{ width: "100px", margin: "5px" }}
            />
          ))}
        </div>
      </div>
    );
  },
  save() {
    return null; // Render di server via render.php
  },
});
