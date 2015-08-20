
import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

/**
 * Created by linroid on 7/26/15.
 */
public class InstallPackage {

    @Expose
    private Integer id;
    @SerializedName("package_name")
    @Expose
    private String packageName;
    @SerializedName("app_name")
    @Expose
    private String appName;
    @SerializedName("version_name")
    @Expose
    private String versionName;
    @SerializedName("version_code")
    @Expose
    private int versionCode;
    @SerializedName("sdk_level")
    @Expose
    private int sdkLevel;
    @SerializedName("user_id")
    @Expose
    private int userId;
    @Expose
    private String icon;
    @SerializedName("created_at")
    @Expose
    private String createdAt;
    @SerializedName("updated_at")
    @Expose
    private String updatedAt;
    @SerializedName("download_url")
    @Expose
    private String downloadUrl;
    /**
     * 本地保存路径
     */
    private String path;

    public String getPath() {
        return path;
    }

    public void setPath(String path) {
        this.path = path;
    }


    /**
     * @return The id
     */
    public Integer getId() {
        return id;
    }

    /**
     * @param id The id
     */
    public void setId(Integer id) {
        this.id = id;
    }

    /**
     * @return The packageName
     */
    public String getPackageName() {
        return packageName;
    }

    /**
     * @param packageName The package_name
     */
    public void setPackageName(String packageName) {
        this.packageName = packageName;
    }

    /**
     * @return The appName
     */
    public String getAppName() {
        return appName;
    }

    /**
     * @param appName The app_name
     */
    public void setAppName(String appName) {
        this.appName = appName;
    }

    /**
     * @return The versionName
     */
    public String getVersionName() {
        return versionName;
    }

    /**
     * @param versionName The version_name
     */
    public void setVersionName(String versionName) {
        this.versionName = versionName;
    }

    /**
     * @return The versionCode
     */
    public int getVersionCode() {
        return versionCode;
    }

    /**
     * @param versionCode The version_code
     */
    public void setVersionCode(int versionCode) {
        this.versionCode = versionCode;
    }

    /**
     * @return The sdkLevel
     */
    public int getSdkLevel() {
        return sdkLevel;
    }

    /**
     * @param sdkLevel The sdk_level
     */
    public void setSdkLevel(int sdkLevel) {
        this.sdkLevel = sdkLevel;
    }

    /**
     * @return The userId
     */
    public Integer getUserId() {
        return userId;
    }

    /**
     * @param userId The user_id
     */
    public void setUserId(Integer userId) {
        this.userId = userId;
    }

    /**
     * @return The icon
     */
    public String getIcon() {
        return icon;
    }

    /**
     * @param icon The icon
     */
    public void setIcon(String icon) {
        this.icon = icon;
    }

    /**
     * @return The createdAt
     */
    public String getCreatedAt() {
        return createdAt;
    }

    /**
     * @param createdAt The created_at
     */
    public void setCreatedAt(String createdAt) {
        this.createdAt = createdAt;
    }

    /**
     * @return The updatedAt
     */
    public String getUpdatedAt() {
        return updatedAt;
    }

    /**
     * @param updatedAt The updated_at
     */
    public void setUpdatedAt(String updatedAt) {
        this.updatedAt = updatedAt;
    }

    /**
     * @return The downloadUrl
     */
    public String getDownloadUrl() {
        return downloadUrl;
    }

    /**
     * @param downloadUrl The downloadUrl
     */
    public void setDownloadUrl(String downloadUrl) {
        this.downloadUrl = downloadUrl;
    }

    @Override
    public String toString() {
        return "InstallPackage{" +
                "id=" + id +
                ", packageName='" + packageName + '\'' +
                ", appName='" + appName + '\'' +
                ", versionName='" + versionName + '\'' +
                ", versionCode=" + versionCode +
                ", sdkLevel=" + sdkLevel +
                ", userId=" + userId +
                ", icon='" + icon + '\'' +
                ", createdAt='" + createdAt + '\'' +
                ", updatedAt='" + updatedAt + '\'' +
                ", downloadUrl='" + downloadUrl + '\'' +
                '}';
    }

    public static class Builder {
        private Integer id;
        private String packageName;
        private String appName;
        private String versionName;
        private int versionCode;
        private int sdkLevel;
        private Integer userId;
        private String icon;
        private String createdAt;
        private String updatedAt;
        private String downloadUrl;
        private String path;

        public Builder() {
        }

        public static Builder anInstallPackage() {
            return new Builder();
        }

        public Builder withId(Integer id) {
            this.id = id;
            return this;
        }

        public Builder withPackageName(String packageName) {
            this.packageName = packageName;
            return this;
        }

        public Builder withAppName(String appName) {
            this.appName = appName;
            return this;
        }

        public Builder withVersionName(String versionName) {
            this.versionName = versionName;
            return this;
        }

        public Builder withVersionCode(int versionCode) {
            this.versionCode = versionCode;
            return this;
        }

        public Builder withSdkLevel(int sdkLevel) {
            this.sdkLevel = sdkLevel;
            return this;
        }

        public Builder withUserId(int userId) {
            this.userId = userId;
            return this;
        }

        public Builder withIcon(String icon) {
            this.icon = icon;
            return this;
        }

        public Builder withCreatedAt(String createdAt) {
            this.createdAt = createdAt;
            return this;
        }

        public Builder withUpdatedAt(String updatedAt) {
            this.updatedAt = updatedAt;
            return this;
        }

        public Builder withDownloadUrl(String downloadUrl) {
            this.downloadUrl = downloadUrl;
            return this;
        }

        public Builder withPath(String path) {
            this.path = path;
            return this;
        }

        public Builder but() {
            return anInstallPackage().withId(id).withPackageName(packageName).withAppName(appName).withVersionName(versionName).withVersionCode(versionCode).withSdkLevel(sdkLevel).withUserId(userId).withIcon(icon).withCreatedAt(createdAt).withUpdatedAt(updatedAt).withDownloadUrl(downloadUrl).withPath(path);
        }

        public InstallPackage build() {
            InstallPackage installPackage = new InstallPackage();
            installPackage.setPackageName(packageName);
            installPackage.setAppName(appName);
            installPackage.setVersionName(versionName);
            installPackage.setVersionCode(versionCode);
            installPackage.setSdkLevel(sdkLevel);
            installPackage.setIcon(icon);
            installPackage.setCreatedAt(createdAt);
            installPackage.setUpdatedAt(updatedAt);
            installPackage.setDownloadUrl(downloadUrl);
            installPackage.setPath(path);
            return installPackage;
        }
    }


}