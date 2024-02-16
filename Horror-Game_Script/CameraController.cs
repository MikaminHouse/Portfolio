using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.SceneManagement;
public class CameraController : MonoBehaviour
{

    public PlayerUI playerUI;
    //マウスの横の移動量を格納
    private float mouse_x;
    //マウスの縦の移動量を格納
    private float mouse_y;
    //回転の速度
    [SerializeField] private float rotateSpeed = 2;
    //カメラが追従する対象
    private GameObject player;
    //カメラとプレイヤーとの距離の差を格納
    private Vector3 offset;
    //アイテムの説明文を表示する
    public Image lightImage;
    public Image keyImage;
    private bool canImage;

    //強化薬の変数//
    private float countDown;  //経過時間を格納する
    private bool useDrug;  //強化薬を使用すると「ture」になる
    private float dashSpeed_be;  //強化前の速度を格納
    public float dashSpeed_af = 20;  //強化後の速度を格納
    private Color dashSliderColor;  //強化前のダッシュスライダーの色を格納
    public GameObject dashSliderFill;  //ダッシュスライダーのスライドを格納

    //Rotate関数//
    public bool canRotate = true;

    //  Name関数  //
    public Text nameText;  //選択しているオブジェクトの名前を表示
    public Text labelText;  //選択しているオブジェクトの状態・操作方法を表示
    public Text itemText;  //スロットに装填しているアイテムの使用方法を表示
    private Ray nameRay;
    //ドアの変数//
    private int canOpen;  //対応する鍵を持っている場合tureになる
    private string doorText;  //ドアの操作方法を表示
    private string openText;  //ドアを施錠する方法を格納
    private string lockText;  //ドアを解錠する方法を格納
    private string lockOpenText;  //鍵付きドアを解錠する方法を格納
    private string lockLockText;  //鍵付きドアを施錠する方法を格納
    private string failText; //ドアに鍵かかかっている時のテキストを格納
    //懐中電灯の変数//
    [SerializeField] private GameObject playerArm;
    [SerializeField] GameObject Light;
    public int batteryCount;
    public List<Image> batteryList = new List<Image>();
    //武器商人の変数//
    public GameObject murabitoPanel;  //アイテム購入のUI
    public GameObject gameController;
    //ライトセイバーの変数//
    public GameObject saberPanel;  //「ライトセイバー」のUIを格納する
    public int crystalCount;  //「オーバーメタル」の個数を格納する
    public int buildCount;  //「オーパーツ設計書」の個数を格納する
    public int overCount;  //「オーバードライブ電池」の個数を格納する
    public Text crystalText;  //「オーバーメタル」の文章
    public Text buildText;  //「オーパーツ設計書」の文章
    public Text overText;  //「オーバードライブ電池」の文章
    public Text makeText;  //ライトセイバーを作成するボタン

    //  Audio関数  //
    /*
    public AudioSource searchAudio;  //探索のBGM
    public AudioSource runAudio;  //逃走のBGM
    public AudioSource heartAudio;  //心音
    */

    private ItemControl itemControl;


    void Start()
    {
        //名前が「Player」のオブジェクトを取得
        player = GameObject.Find("Player");
        player.GetComponent<PlayerController>().canMove = true;
        //カメラとプレイヤーとの距離の差を取得
        offset = transform.position - player.transform.position;
        //ドアにカーソルを合わせた時の文章
        openText = "[マウス左クリック]で開く\n[Rキー]で施錠する";
        lockText = "[Rキー]で解錠する";
        lockOpenText = "[Cキー]で鍵を使用して解錠する";
        lockLockText = "[Cキー]で鍵を使用して施錠する";
        failText = "専用の鍵が必要そうだ";
        itemControl = GetComponent<ItemControl>();
    }

    // Update is called once per frame
    void Update()
    {
        
        if (canRotate)
        {
            Rotate();
        }
        Act();
        ExtraItems();
        if (useDrug)
        {
            countDown += Time.deltaTime;
            Debug.Log(countDown);
            player.GetComponent<PlayerController>().dashSpeed = dashSpeed_af;  //プレイヤーのダッシュスピードをアップさせる
            if(countDown > 10)
            {
                useDrug = false;
                player.GetComponent<PlayerController>().dashSpeed = dashSpeed_be;  //プレイヤーのダッシュスピードを基に戻す
                player.GetComponent<PlayerController>().useDash = true;
                dashSliderFill.GetComponent<Image>().color = dashSliderColor;
                countDown = 0;
            }
        }
    }
    public void Rotate()  //回転関数
    {
        //プレイヤーとカメラの相対距離を求め、一定の距離を保ちながらプレイヤーに合わせてカメラも移動する
        GetComponent<Transform>().position = player.transform.position + offset;
        mouse_x = Input.GetAxis("Mouse X");
        mouse_y = Input.GetAxis("Mouse Y");
        Vector3 cameraRotate = transform.localEulerAngles;
        cameraRotate.x -= mouse_y * rotateSpeed;
        cameraRotate.y += mouse_x * rotateSpeed;
        transform.localEulerAngles = cameraRotate;
        //プレイヤーの腕を視点に合わせて動かす
        mouse_y = Input.GetAxis("Mouse Y");
        Vector3 armRotate = playerArm.transform.localEulerAngles;
        armRotate.x += mouse_y * rotateSpeed;
        playerArm.transform.localEulerAngles = armRotate;
    }
    public void Act()  //アイテムの取得・使用、ドアの開閉、ドアの解錠・施錠の関数、アイテムの使用
    {
        //Rayを生成・射出する//
        Vector3 MoveForward = Vector3.Scale(Camera.main.transform.forward, new Vector3(1, 1, 1)).normalized;
        nameRay = new Ray(Camera.main.transform.position, MoveForward);
        RaycastHit hit;
        Physics.Raycast(nameRay, out hit, 3.5f);
        if (hit.collider != null)
        {
            //  アイテムを拾うときの処理  //
            if (hit.collider.gameObject.tag == "Item")
            {
                ItemScript itemScript = hit.collider.gameObject.GetComponent<ItemScript>();  //アイテムのスクリプトを取得
                nameText.text = itemScript.itemName;  //アイテムの名前を表示
                if (Input.GetMouseButtonDown(0))
                {
                    itemControl.Item(hit.collider.gameObject);
                }
            }
            if(hit.collider.gameObject.tag == "BedLight")  //ベッドのライト
            {
                if (hit.collider.GetComponent<BedLightScript>().canBedLight == true) nameText.text = "[左クリック]で明かりを消す";
                else if (hit.collider.GetComponent<BedLightScript>().canBedLight == false) nameText.text = "[左クリック]で明かりを付ける";
                if (Input.GetMouseButtonDown(0))
                {
                    hit.collider.GetComponent<BedLightScript>().canBedLight = !hit.collider.GetComponent<BedLightScript>().canBedLight;
                }

            }
            //  武器商人に話しかける時の処理  //
            else if(hit.collider.gameObject.tag == "Murabito")
            {
                nameText.text = "[左クリック]で話しかける";
                if (Input.GetMouseButtonDown(0))
                {
                    murabitoPanel.SetActive(true);  //武器商人のUIを表示させる
                    canRotate = false;  //カメラの操作を無効化する
                    player.GetComponent<PlayerController>().canMove = false;  //プレイヤーの操作を無効化する
                    //gameController.GetComponent<GameController>().canCursor = true;
                    nameText.text = "";
                }
                else if (Input.GetMouseButtonDown(1))
                {
                    murabitoPanel.SetActive(false);  //武器商人のUIを非表示にさせる
                    canRotate = true;  //カメラの操作を有効化する
                    player.GetComponent<PlayerController>().canMove = true;  //プレイヤーの操作を有効化する
                    Camera.main.GetComponent<CameraController>().canRotate = true;
                    //gameController.GetComponent<GameController>().canCursor = false;
                }
            }
            //  ドアを開ける処理  //
            else if (hit.collider.gameObject.tag == "Door")
            {
                //ドアのスクリプトを取得
                DoorController doorController = hit.collider.gameObject.GetComponent<DoorController>();

                //ドアの状態によって操作方法を表示
                if (doorController.lockType) doorText = openText;
                else if (doorController.lockType == false) doorText = lockText;

                //鍵がかかっていない場合
                if (doorController.lockType && Input.GetMouseButtonDown(0))
                {
                    doorController.DoorMove();
                }
                //鍵がかかっている場合
                else if (doorController.lockType == false && Input.GetMouseButtonDown(0))
                {
                    lockText = "鍵がかかっている\n[Rキー]で解錠する";
                    doorController.failAudio.Play();
                }
                labelText.text = doorText;
                //ドアが閉まっている時
                if (doorController.doorMove == false && Input.GetKeyDown(KeyCode.R))
                {
                    doorController.lockType = !doorController.lockType;
                    doorController.lockAudio.Play();
                    lockText = "[Rキー]で解錠する";
                }
            }
            //  鍵付きドアを開ける処理  //
            else if (hit.collider.gameObject.tag == "Lock")
            {
                //鍵付きドアのスクリプトを取得
                LockController lockController = hit.collider.gameObject.GetComponent<LockController>();
                nameText.text = lockController.doorName;
                //メインスロットに鍵を装填している時
                if (itemControl.itemTypeList.Count > 0 && itemControl.itemTypeList[itemControl.listNumber] == "key")
                {
                    //ドアの状態によって操作方法を表示
                    if (lockController.lockType) doorText = lockLockText;  //鍵が開いている時のテキスト
                    else if (lockController.lockType == false) doorText = lockOpenText;  //鍵が閉まっている時のテキスト
                    labelText.text = doorText;  
                    itemText.text = lockOpenText;  //操作方法を表示
                    //鍵を使用した時
                    if (Input.GetKeyDown(KeyCode.C))
                    {
                        for (int i = 0; i < itemControl.itemNameList.Count; i++)
                        {
                            //対応する鍵を持っていて、メインスロットに装填している時
                            if (lockController.keyName == itemControl.itemNameList[i] && itemControl.listNumber == i)
                            {
                                canOpen = 1;
                            }
                        }
                        if(canOpen == 1)  //対応する鍵を持っていて、メインスロットに装填している時
                        {
                            if (lockController.lockType == false)  //鍵を開ける
                            {
                                lockController.lockType = true;
                                lockLockText = "鍵が開いた\n[Cキー]で鍵を使用して施錠する";
                            }
                            else if (lockController.lockType && lockController.doorMove == false)  //鍵を閉める（ドアを閉めている時のみ有効）
                            {
                                lockController.lockType = false;
                                lockOpenText = "鍵を閉めた\n[Cキー]で鍵を使用して解錠する";
                            }
                            canOpen = 0;  //変数を初期化
                        }
                        else if(canOpen == 0)  //対応する鍵をメインスロットに装填していない時
                        {
                            lockOpenText = "どうやら鍵が違うようだ";
                            lockLockText = "どうやら鍵が違うようだ";
                        }
                    }
                }
                //メインスロットに鍵を装填していない時
                else
                {
                    labelText.text = failText;
                    if (Input.GetMouseButtonDown(0))
                    {
                        failText = "専用の鍵が必要そうだ\n鍵がかかっている";
                    }
                }
                //ドアを開ける処理
                if (Input.GetMouseButtonDown(0))
                {
                    //鍵が閉まっている時
                    if(lockController.lockType == false) lockOpenText = "鍵がかかっている";
                    //鍵が開いている時
                    else if(lockController.lockType) lockController.DoorMove();
                }
            }
            else if(hit.collider.gameObject.tag == "LastDoor")  //ボス部屋前のドア
            {
                LastDoorScript lastDoorScript = hit.collider.GetComponent<LastDoorScript>();
                if (lastDoorScript.doorMove == false)  //閉まっている時
                {
                    //「ボス戦に挑みますか？（一度入ると戻ることはできません）」の表記を出す
                    //labelText.text = "ボス戦に挑みますか？\n※一度入ると戻ることはできません";
                    if (Input.GetMouseButtonDown(0))
                    {
                        //lastDoorScript.DoorMove();
                        SceneManager.LoadScene("EndScene");

                    }
                }
            }
            else if(hit.collider.gameObject.tag == "Slot")
            {
                kaiten slot = hit.collider.gameObject.GetComponent<kaiten>();
                nameText.text = "[左クリック]でプレイする";
                if (Input.GetMouseButtonDown(0))
                {
                    slot.canCamera = true;
                    slot.canSlot = true;
                    slot.patiPanel.SetActive(true);
                    nameText.text = "";
                    player.GetComponent<PlayerController>().enabled = false;
                    Light.GetComponent<FlashLight>().enabled = false;
                    Camera.main.GetComponent<CameraController>().enabled = false;
                }
            }
        }
        else//テキストの初期化
        {
            nameText.text = "";
            labelText.text = "";
            openText = "[マウス左クリック]で開く\n[Rキー]で施錠する";
            lockText = "[Rキー]で解錠する";
            lockOpenText = "[Cキー]で鍵を使用して解錠する";
            lockLockText = "[Cキー]で鍵を使用して施錠する";
            failText = "専用の鍵が必要そうだ";
        }
        //リストの要素が1個以上で、メインスロットに装填されているアイテムが回復薬だった場合
        if (itemControl.itemTypeList.Count > 0 && itemControl.itemTypeList[itemControl.listNumber] == "medicine")
        {
            itemControl.slotText.text = $"{itemControl.itemNameList[itemControl.listNumber]} × {itemControl.medicineCount}";
            itemText.text = "[Cキー]で回復薬を使用する";

            if (Input.GetKeyDown(KeyCode.C))
            {
                if (player.GetComponent<PlayerController>().lifeSlider.value < 100)
                {
                    player.GetComponent<PlayerController>().lifeSlider.value += 20;
                    itemControl.medicineCount -= 1;
                    if (itemControl.medicineCount == 0)
                    {
                        labelText.text = "";
                        itemControl.itemTypeList.RemoveAt(itemControl.listNumber);
                        itemControl.itemNameList.RemoveAt(itemControl.listNumber);
                        itemControl.itemImageList.RemoveAt(itemControl.listNumber);
                        itemControl.slotImageList[0].sprite = itemControl.blankImage;
                        nameText.text = "";  //アイテムの操作方法を初期化
                        itemControl.slotText.text = "";  //メインスロットのアイテム名を初期化
                        itemControl.SlotSort();
                    }
                }
                else if (player.GetComponent<PlayerController>().lifeSlider.value == 100) labelText.text = "体力が満タンだ。";

            }
        }
        //リストの要素が1個以上で、メインスロットに装填されているアイテムが強化薬だった場合
        else if (itemControl.itemTypeList.Count > 0 && itemControl.itemTypeList[itemControl.listNumber] == "drug")
        {
            itemControl.slotText.text = $"{itemControl.itemNameList[itemControl.listNumber]} × {itemControl.drugCount}";
            itemText.text = "[Cキー]で強化薬を使用する";
            if (Input.GetKeyDown(KeyCode.C))
            {
                useDrug = true;
                dashSpeed_be = player.GetComponent<PlayerController>().dashSpeed;  //プレイヤーのダッシュ時の速度を取得
                player.GetComponent<PlayerController>().useDash = false;  //ダッシュスライダーが減らないようにする
                dashSliderColor = dashSliderFill.GetComponent<Image>().color;
                dashSliderFill.GetComponent<Image>().color = Color.red;
                itemControl.drugCount -= 1;
                if (itemControl.drugCount == 0)
                {
                    labelText.text = "";
                    itemControl.itemTypeList.RemoveAt(itemControl.listNumber);
                    itemControl.itemNameList.RemoveAt(itemControl.listNumber);
                    itemControl.itemImageList.RemoveAt(itemControl.listNumber);
                    itemControl.slotImageList[0].sprite = itemControl.blankImage;
                    nameText.text = "";  //アイテムの操作方法を初期化
                    itemControl.slotText.text = "";  //メインスロットのアイテム名を初期化
                    itemControl.SlotSort();
                }
            }
        }
        else
        {
            itemText.text = "";
        }
    }
    public void ExtraItems()  //ライトセイバーを作るのに必要なアイテムのUI制御
    {
        if (crystalCount > 0 || buildCount > 0 || overCount > 0) saberPanel.gameObject.SetActive(true);
        crystalText.text = $"オーバーメタル：{crystalCount}/3個";
        buildText.text = $"オーパーツ設計書：{buildCount}/3枚";
        overText.text = $"オーバードライブ電池：{overCount}/3個";
        if(crystalCount == 3 && buildCount == 3 || overCount == 3)
        {
            makeText.gameObject.SetActive(true);
        }
    }
    
}