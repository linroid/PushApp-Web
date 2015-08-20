import com.google.gson.Gson;
import net.dongliu.apk.parser.ApkParser;
import net.dongliu.apk.parser.bean.ApkMeta;

import java.io.FileOutputStream;
import java.io.OutputStream;
import java.util.Locale;

public class Main {

    public static void main(String[] args) {
        try {
            String apkFile = args[0];
            String iconOutFile =  args[1];
            ApkParser parser = new ApkParser(apkFile);
            parser.setPreferredLocale(Locale.SIMPLIFIED_CHINESE);
            byte[] icon = parser.getIconFile().getData();
            OutputStream os = new FileOutputStream(iconOutFile);
            os.write(icon);
            ApkMeta meta = parser.getApkMeta();
            InstallPackage pack  = new InstallPackage.Builder()
                    .withAppName(meta.getLabel())
                    .withPackageName(meta.getPackageName())
                    .withSdkLevel(Integer.parseInt(meta.getMinSdkVersion()))
                    .withVersionCode(meta.getVersionCode().intValue())
                    .withVersionName(meta.getVersionName())
                    .build();
            String json =  new Gson().toJson(pack);
            System.out.print(json);
        } catch (Exception ignored) {
            System.err.print("error");
        }
    }
}
